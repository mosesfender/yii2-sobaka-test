module articles
{
    export class TArticleBlock extends HTMLDivElement
    {
        
        connectedCallback()
        {
        
        }
        
        get sort(): number
        {
            return Number(this.sortInput.value);
        }
        
        set sort(val: number)
        {
            this.sortInput.value = String(val);
        }
        
        get sortInput(): HTMLInputElement
        {
            return this.querySelector('input[name*="[sort]"]');
        }
        
        get idInput(): HTMLInputElement
        {
            return this.querySelector('input[name*="[id]"]');
        }
        
        set blockID(val: string | number)
        {
            this.idInput.value = String(val);
        }
        
        get blockID(): string
        {
            return this.idInput.value;
        }
        
        
        get blockList(): TArticleBlockList
        {
            return <TArticleBlockList>this.parentElement;
        }
        
        createYiiData(id: string): Array<IValidateObject>
        {
            let res: Array<IValidateObject> = [];
            [].map.call(this.querySelectorAll('[class*="field-article"]'), (el: HTMLElement) => {
                let na = el.getAttribute('class').replace('0', id);
                el.setAttribute('class', na);
                let input = el.querySelector('input,textarea') as HTMLElement;
                input.id  = input.id.replace('0', id);
                
                if ((input instanceof HTMLTextAreaElement)
                    || (input instanceof HTMLInputElement && input.getAttribute('type') == TBlockTypes.BLOCK_TYPE_TEXT)) {
                    let valparam: IValidStrParam = {};
                    if (input.hasAttribute('max')) {
                        let max          = valparam.max = Number(input.getAttribute('max'));
                        let tooLong      = input.getAttribute('tooLong');
                        valparam.tooLong = `${tooLong}`;
                    }
                    valparam.skipOnEmpty = 1;
                    let containerClass: string;
                    for (let cls of el.classList.entries()) {
                        if (cls[1].search('field-article')) {
                            containerClass = cls[1];
                            break;
                        }
                    }
                    let obj = <IValidateObject>{
                        id       : input.id,
                        name     : input.getAttribute('name').match(/.+\[.+\]\[(.+)\]/)[1],
                        container: `.${containerClass}`,
                        input    : `#${input.id}`,
                        error    : '.invalid-feedback',
                        validate : function (attribute, value, messages, deferred, $form) {
                            // @ts-ignore
                            yii.validation.string(value, messages, valparam);
                        }
                    }
                    res.push(obj);
                }
            });
            return res;
        }
    }
}

customElements.define('article-block', articles.TArticleBlock, {extends: 'div'});