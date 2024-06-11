/**
 * Функция назначает слушателя на флажки выбора языка.
 * Слушатель флажка записывает куку с кодом языка и делает reload страницы.
 * У базового контроллера в beforeAction происходит всё остальное в соответствии со значением из куки.
 * @constructor
 */
let LanguageChoose = function () {
    this.element = document.querySelector('.lang-choose');
    [].map.call(this.element.querySelectorAll('.flag'), (el: HTMLElement) => {
        el.addEventListener('click', (ev: PointerEvent) => {
            let lang = (ev.target as HTMLElement).getAttribute('data-lang');
            cookie.write('sobaka.lang', lang);
            location.reload();
        });
    });
}
