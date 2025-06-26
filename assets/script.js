document.addEventListener('DOMContentLoaded', function() {
    // Mostra o primeiro bloco por padrão
    const firstBlock = document.querySelector('.content-block.active');
    if (firstBlock) {
        firstBlock.classList.add('active');
        const firstLink = document.querySelector('.seletorColecoes .elementor-icon-list-item a[href="#' + firstBlock.classList[1] + '"]');
        if (firstLink) {
            firstLink.parentElement.classList.add('active');
        }
    }

    // Adiciona evento de clique aos links
    const links = document.querySelectorAll('.seletorColecoes .elementor-icon-list-item a');
    links.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();

            // Remove a classe 'active' de todos os blocos e itens de lista
            document.querySelectorAll('.content-block').forEach(block => {
                block.classList.remove('active');
            });
            document.querySelectorAll('.seletorColecoes .elementor-icon-list-item').forEach(item => {
                item.classList.remove('active');
            });

            // Adiciona a classe 'active' ao bloco correspondente e ao item de lista
            const targetClass = this.getAttribute('href').substring(1); // Remove o #
            const targetBlock = document.querySelector(`.content-block.${targetClass}`);
            if (targetBlock) {
                targetBlock.classList.add('active');
            }
            this.parentElement.classList.add('active');
        });
    });
});