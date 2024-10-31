<?php 
    namespace App\cpms\Models\helper;

    use Dompdf\Dompdf;

    if(!defined('C8L6K7E')){
        // header("Location: /");
        die("Erro: Página não encontrada<br>");
    }

    class CpmsGeneratePdf {
        private string|null $data;

        public function GeneratePdf(string|null $data){
            $dompdf = new Dompdf();
            $dompdf->loadHtml($data);

            $dompdf->setPaper('A4', 'landscape');

            $dompdf->render();

            $dompdf->stream();
        }
    }
?>