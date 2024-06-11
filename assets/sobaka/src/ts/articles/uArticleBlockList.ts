module articles
{
    export interface IAddBlockData
    {
        type: string,
        pos: string,
        relativeElement: HTMLElement
    }
    
    export enum Events
    {
        EV_ADD_BLOCK_COMMAND = 'abl:add_block_command',
        EV_ADD_BLOCK         = 'abl:add_block',
        EV_MOVE_BLOCK        = 'abl:move_block',
        EV_REMOVE_BLOCK      = 'abl:remove_block',
    }
    
    export class TArticleBlockList extends HTMLDivElement
    {
        connectedCallback(): void
        {
            this.addEventListener(Events.EV_ADD_BLOCK, (ev: CustomEvent) => {
                this.updateSort();
            });
            this.addEventListener(Events.EV_MOVE_BLOCK, (ev: CustomEvent) => {
                this.updateSort();
            });
            this.addEventListener(Events.EV_REMOVE_BLOCK, (ev: CustomEvent) => {
                this.updateSort();
            });
            this.eventListener(Events.EV_ADD_BLOCK_COMMAND, (ev: CustomEvent) => {
                let data: IAddBlockData = ev.detail;
                this.createBlock(data.type, data.pos, data.relativeElement);
            });
        }
        
        /**
         * Создание нового блока
         */
        createBlock(type: string, position: string, relative: HTMLElement): TArticleBlock
        {
            let tplid          = `template-${type}`;
            let tmpid          = `t${Math.floor(Math.random() * 10000) + 1}`;
            let fragment       = document.createElement('div');
            fragment.innerHTML = tmpl(tplid, {id: tmpid});
            let block          = fragment.childNodes.item(1) as TArticleBlock;
            block.classList.add('invisible');
            
            let pos: InsertPosition;
            if (relative instanceof TArticleBlockList) {
                switch (position) {
                    case TPosition.POS_END:
                        pos = 'beforeend';
                        break;
                    case TPosition.POS_BEGIN:
                        pos = 'afterbegin';
                        break;
                }
                this.insertAdjacentElement(pos, block);
            }
            
            let attrs = block.createYiiData(tmpid);
            attrs.forEach((obj: IValidateObject) => {
                // @ts-ignore
                $(this.form).yiiActiveForm('add', obj);
            });
            
            block.classList.remove('invisible');
            this.dispatchEvent(new CustomEvent(Events.EV_ADD_BLOCK));
            return block;
        }
        
        /**
         * Устанавливает порядок сортировки блоков
         */
        updateSort(): void
        {
            [].map.call(this.blocks, (block: TArticleBlock, idx: number) => {
                block.sort = idx + 1;
            });
        }
        
        /**
         * @returns NodeList
         */
        get blocks(): NodeList
        {
            return this.querySelectorAll('article-block, [is="article-block"]');
        }
        
        get form(): HTMLFormElement
        {
            return this.closest('form');
        }
    }
}

customElements.define('article-block-list', articles.TArticleBlockList, {extends: 'div'});