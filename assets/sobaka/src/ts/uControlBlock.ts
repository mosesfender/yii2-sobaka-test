module mf {
    export class TControlBlock extends HTMLDivElement {
        
        protected _lever: HTMLElement;
        
        constructor() {
            super();
            this._lever = document.createElement('dd');
            this.appendChild(this._lever);
            this._lever.addEventListener('click', (ev: MouseEvent) => {
                if (this.classList.contains('expanded')) {
                    this.classList.remove('expanded');
                } else {
                    this.classList.add('expanded');
                }
            });
        }
        
        connectedCallback() {
        
        }
    }
}

customElements.define('mf-control-block', mf.TControlBlock, {extends: 'div'});