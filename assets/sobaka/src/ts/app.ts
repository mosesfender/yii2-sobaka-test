let tooltips = (el: Element|Document) => {
    const tooltipTriggerList = el.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList        = [...tooltipTriggerList].map(
        // @ts-ignore
        tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
}

document.addEventListener('DOMContentLoaded', () => {
    LanguageChoose();
    
    /* Костыль. У индуса в виджете для загрузки картинок класс .is-invalid находится не на одном уровне,
    поэтому сообщения об ошибках не видны на экране. С помощью CSS эта порча не снимается,
    нужно что-то придумать, а пока будем просто включать его принудительно. */
    $('input[name*="figureFile"][type="file"]').on('change', (ev) => {
        setTimeout(() => {
            if ((<HTMLInputElement>ev.currentTarget).classList.contains('is-invalid')) {
                $(ev.target)
                    .closest('[class*="field-figure-figurefile"]')
                    .children('.invalid-feedback')
                    .show();
            } else {
                $(ev.target)
                    .closest('[class*="field-figure-figurefile"]')
                    .children('.invalid-feedback')
                    .hide();
            }
        }, 600);
    })
  
    tooltips(document);
});