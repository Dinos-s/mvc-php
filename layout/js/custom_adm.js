// dropdown
let notification = document.querySelector('.notification')
let avatar = document.querySelector('.avatar')

dropMenu(avatar);
dropMenu(notification);

function dropMenu(selector) {
    selector.addEventListener('click', ()=>{
        let dropdownMenu = selector.querySelector('.dropdown-menu')
        dropdownMenu.classList.contains('active') ? dropdownMenu.classList.remove('active') : dropdownMenu.classList.add('active')
    })
}

// sidebar
let sidebar = document.querySelector('.sidebar')
let bars = document.querySelector('.bars')

bars.addEventListener('click', ()=>{
    sidebar.classList.contains('active') ? sidebar.classList.remove('active') : sidebar.classList.add('active')
})