/*
 * Copyright © Sergey Siunov. 2024
 * email: <sergey@siunov.ru>
 */

module articles
{
    export enum TPosition
    {
        POS_BEGIN  = 'begin',
        POS_END    = 'end',
        POS_BEFORE = 'before',
        POS_AFTER  = 'after',
    }
    
    export abstract class TAddLever extends HTMLDivElement
    {
        static _tpl: string;
        
        protected _posValue: string  = undefined;
        protected _typeValue: string = undefined;
        
        connectedCallback()
        {
            this.buttonCancel.eventListener('click', (ev: MouseEvent) => {
                ev.preventDefault();
                TAddLever.destroy();
            });
            this.buttonOk.eventListener('click', (ev: MouseEvent) => {
                ev.preventDefault();
                this.createBlock();
                TAddLever.destroy();
            });
            
            this.posInputs.forEach((input: Node) => {
                input.eventListener('change', (ev: Event) => {
                    this.dispatchEvent(
                        new CustomEvent('ab:change',
                                        {detail: this.querySelector('input[name="btnpos"]:checked')}));
                });
            });
            
            this.typeInputs.forEach((input: Node) => {
                input.eventListener('change', (ev: Event) => {
                    this.dispatchEvent(
                        new CustomEvent('ab:change',
                                        {detail: this.querySelector('input[name="btntype"]:checked')}));
                });
            });
            
            this.eventListener('ab:change', (ev: CustomEvent) => {
                if (ev.detail.name == 'btnpos') {
                    this._posValue = ev.detail.value;
                }
                if (ev.detail.name == 'btntype') {
                    this._typeValue = ev.detail.value;
                }
                
                if (this._posValue && this._typeValue) {
                    this.buttonOk.classList.remove('disabled');
                }
            });
        }
        
        protected abstract createBlock();
        
        get buttonCancel()
        {
            return this.querySelector('.btn-cancel') as HTMLElement;
        }
        
        get buttonOk()
        {
            return this.querySelector('.btn-ok') as HTMLElement;
        }
        
        get posInputs()
        {
            return this.querySelectorAll('input[name="btnpos"]') as NodeList;
        }
        
        get typeInputs()
        {
            return this.querySelectorAll('input[name="btntype"]') as NodeList;
        }
        
        get mainer()
        {
            return document.querySelector('article-form, [is="article-form"]') as TArticleForm;
        }
        
        static create(ev: MouseEvent)
        {
            let parent = ev.target as HTMLElement;
            TAddLever.destroy();
            
            parent.style.position = 'relative';
            
            document.body.insertAdjacentHTML('beforeend',
                                             document.querySelector('#template_add_lever_main').innerHTML);
            let isset = TAddLever.find();
            if (isset instanceof HTMLElement) {
                isset.style.left    = parent.offsetLeft + parent.offsetWidth + 10 + 'px';
                isset.style.top     = parent.offsetTop + 'px';
                isset.style.opacity = '1';
            }
            tooltips(parent);
        }
        
        static find()
        {
            return document.getElementById('add_lever');
        }
        
        static destroy()
        {
            let isset = TAddLever.find();
            if (isset instanceof HTMLElement) {
                // @ts-ignore
                delete isset.parentElement.removeChild(isset);
            }
        }
    }
    
    export class TMainAddLever extends TAddLever
    {
        static _tpl = 'template_add_lever_main';
        
        protected createBlock()
        {
            let data: IAddBlockData = {
                type           : this._typeValue,
                pos            : this._posValue,
                relativeElement: this.mainer.articleList
            };
            this.mainer.articleList.dispatchEvent(new CustomEvent(Events.EV_ADD_BLOCK_COMMAND, {detail: data}));
        }
    }
    
    
    export class TBlockAddLever extends TAddLever
    {
        static _tpl = 'template_add_lever_second';
        
        protected createBlock()
        {
        }
    }
}

customElements.define('block-add-lever-main', articles.TMainAddLever, {extends: 'div'});
customElements.define('block-add-lever-second', articles.TBlockAddLever, {extends: 'div'});