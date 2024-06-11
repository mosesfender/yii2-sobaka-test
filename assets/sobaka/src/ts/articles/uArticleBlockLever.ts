/*
 * Copyright © Sergey Siunov. 2024
 * email: <sergey@siunov.ru>
 */

module articles{
    export class TArticleBlockLever extends HTMLDivElement {
        insertBlockHandler(ev: MouseEvent){
            TMainAddLever.create(ev);
        }
    }
}

customElements.define('article-block-lever', articles.TArticleBlockLever, {extends: 'div'});