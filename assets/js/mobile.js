window.onload = () => {

    const closeButton = document.getElementById('close-mobile-menu');
    const openButton = document.getElementById('open-mobile-menu');
    const sidebar = document.querySelector('.mobile-sidebar');

    console.log(sidebar);

    const toggleSidebar = (e) => {
        console.log(e)
        document.querySelector('.mobile-sidebar').classList.toggle('opened');
        console.log('works', sidebar);
        
    }

    openButton.addEventListener('click', toggleSidebar);
    closeButton.addEventListener('click', toggleSidebar);

    window.onclick = (event) => {
        console.log(event.target.closest('.mobile-sidebar'), event.target.closest('.mobile-menu-button'));
        if (!event.target.closest('.mobile-sidebar') && !event.target.closest('.mobile-menu-button')) {
            sidebar.classList.remove('opened');
        }
    }
    
}