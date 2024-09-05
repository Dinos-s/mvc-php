<?php

namespace App\adms\Models;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Irá sincronizar os niveis de acesso com as páginas cadastradas;
 * Pense assim: 66 são os controllers cadastrados na tabela "adms_pages" e 
 * 4 são as permissões de niveis de acesso na tabela "adms_access_levels";
 * 66 * 4 = 264 -> que será o total de registros na tabela "amds_levels_pages", niveis de acesso das páginas;
 * 
 * Para cada pagina que será acessada ela, terá cada nível de acesso que está armazenenado na tabela "adms_access_levels";
 * Isso pode ser aumentado, comforme mais registros serão em ambas as tabelas forem acresentadas;
 * @author Celke
 */
class AdmsSyncPagesLevels
{
    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBD Recebe os registros do banco de dados */
    private array|null $resultBD;

    /** @var array|null $resultBdLevels Recebe os registros do banco de dados */
    private array|null $resultBdLevels;

    /** @var array|null $resultBdPages Recebe os registros do banco de dados */
    private array|null $resultBdPages;

    /** @var array|null $resultBdLevelPages Recebe os registros do banco de dados */
    private array|null $resultBdLevelPage;

    /** @var array|null $resultBdLastOrder Recebe os registros do banco de dados */
    private array|null $resultBdLastOrder;

    /** @var array|null $dataLevelPage Recebe as informaçõs que serão salvas no banco de dados*/
    private array|null $dataLevelPage;

    /** @var array|null $levelId Recebe o id do nível de acesso */
    private int|string|null $levelId;

    /** @var array|null $levelId Recebe tipo de permissão */
    private int|string|null $publish;

    /** @var array|null $pageId Recebe o id da página */
    private int|string|null $pageId;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * @return bool Retorna os detalhes do registro
     */
    function getResultBd(): array|null
    {
        return $this->resultBD;
    }

    /**
     * Lista todos os dados da tabela de nívei de acesso;
     * Se existir, instancia a função listPages();
     * Se não tiver nenhum nível de acesso, retorna o erro para usuário;
    */
    public function syncPagesLevels(): void
    {
        $listLevels = new \App\adms\Models\helper\AdmsRead();
        $listLevels->fullRead("SELECT id FROM adms_access_levels");

        $this->resultBdLevels = $listLevels->getResult();        
        if ($this->resultBdLevels) {
            $this->listPages();
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Nível de acesso não encontrado!</p>";
            $this->result = false;
        }
    }

    /**
     * Lista todos os dados da tabela de páginas cadastradas;
     * Se existir, instancia a função readLevels();
     * Se não tiver nenhuma página cadastrada, retorna o erro para usuário;
    */
    private function listPages(): void
    {
        $listPages = new \App\adms\Models\helper\AdmsRead();
        $listPages->fullRead("SELECT id, publish FROM adms_pages");

        $this->resultBdPages = $listPages->getResult();        
        if ($this->resultBdPages) {
            $this->readLevels();
        } else { 
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Nenhuma página encontrada!!</p>";
            $this->result = false;
        }
    }

    /** 
     * Para cada nível de acesso cadastrado, recebemos o id de cada nível de acesso;
     * armazena o id na variável levelId; 
     * Instancia a readPages();
    */
    private function readLevels(): void
    {
        foreach ($this->resultBdLevels as $level) {
            extract($level);
            $this->levelId = $id;
            $this->readPages();
        }
    }

    /** 
     * Para cada página cadastrada, recebemos o id e a publicação de cada página;
     * A publição informa se a página está disponivel ou não;
     * armazena o id na variável pageId;
     * armazena a publish na variável publish;
     * Instancia a searchLevelPage();
    */
    private function readPages(): void{
        foreach ($this->resultBdPages as $page) {
            extract($page);
            $this->pageId = $id;
            $this->publish = $publish;
            $this->searchLevelPage();
        }
    }   

    /** 
     * Lista todos os dados da tabela "amds_levels_pages", desde que,
     * o id dos níveis de acesso, e o id das páginas, sejam as mesmas que as informadas nas variavei levelId e pageId;
     * 
     * Caso a condição do select seja verdadeira, retorna uma mensagem de sucesso para o usuário logado;
     * Casoa não seja aceita, instaciamos o addLevelPermission();
    */
    private function searchLevelPage(): void {
        $listLevelPage = new \App\adms\Models\helper\AdmsRead();
        $listLevelPage->fullRead(
            "SELECT id
            FROM adms_levels_pages
            WHERE adms_access_level_id =:adms_access_level_id 
            AND adms_page_id =:adms_page_id", 
            "adms_access_level_id={$this->levelId}&adms_page_id={$this->pageId}"
        );

        $this->resultBdLevelPage = $listLevelPage->getResult();
        if ($this->resultBdLevelPage) {
            $_SESSION['msg'] = "<p style='color: green'>Todas as permissões estão sincronizadas!</p>";
            $this->result = true;
        } else {
            $this->addLevelPermission();
        }
    }

    /**
     * cadastrar tabela "adms_levels_pages"
     * Cadastramos as informações na tabela de niveis de paginas;
     * 
     * na coluna permission: 
     *    - 1: acesso permitido;
     *    - 2: acesso negado;
     * 
     * Caso o levelId da página seja 1(super adm) **OU** 
     * Quando a página for publica, permiti o cadastro;
     * 
     * Na coluna da nivel de ordem da página, comparamos a ordem anterior e acescenta o +1, para essa 'hierarquia';
    */
    private function addLevelPermission():void {
        $this->searchLastOrder();
        $this->dataLevelPage['permission'] = (($this->levelId == 1) OR ($this->publish == 1)) ? 1 : 2;
        $this->dataLevelPage['order_level_page'] = $this->resultBdLastOrder[0]['order_level_page'] + 1;
        $this->dataLevelPage['adms_access_level_id'] = $this->levelId;
        $this->dataLevelPage['adms_page_id'] = $this->pageId;
        $this->dataLevelPage['created'] = date("Y-m-d H:i:s");

        $addAccessLevel = new \app\adms\Models\helper\AdmsCreate();
        $addAccessLevel->exeCreate("amds_levels_pages", $this->dataLevelPage);

        if ($addAccessLevel->getResult()) {
            $_SESSION['msg'] = "<p style='color: green'>Permissões sincronizadas com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color:#f00'>Erro: Permissões não podem ser sincronizadas!</p>";
            $this->result= false;
        }
    }

    // verifica se a página está cadastrada para o nível de acesso na tabela adms_levels_pages;
    private function searchLastOrder():void {
        $viewLastOrder = new \App\adms\Models\helper\AdmsRead;
        $viewLastOrder->fullRead(
            "SELECT order_level_page, adms_access_level_id 
            FROM adms_levels_pages
            WHERE adms_access_level_id =:adms_access_level_id
            ORDER BY order_level_page DESC
            LIMIT :limit",
            "adms_access_level_id={$this->levelId}&limit=1"
        );

        $this->resultBdLastOrder = $viewLastOrder->getResult();
        if(!$this->resultBdLastOrder){
            $this->resultBdLastOrder[0]['order_level_page'] = 0;
        }
        // var_dump($this->resultBdLastOrder);
    }
}
