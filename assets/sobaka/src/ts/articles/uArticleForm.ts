module articles
{
    export class TArticleForm extends HTMLDivElement
    {
        connectedCallback()
        {
            this.addEventListener('click', (ev: MouseEvent) => {
                if ((ev.target as HTMLElement).classList.contains('insert-block')) {
                    ((ev.target as HTMLElement).closestType(articles.TArticleBlockLever) as articles.TArticleBlockLever)
                        .insertBlockHandler(ev);
                }
            });
        }
        
        private _articleList: TArticleBlockList;
        get articleList()
        {
            if (!this._articleList) {
                this._articleList = this.querySelector(
                    'article-block-list, [is="article-block-list"]') as TArticleBlockList;
            }
            return this._articleList;
        }
    }
}

customElements.define('article-form', articles.TArticleForm, {extends: 'div'});