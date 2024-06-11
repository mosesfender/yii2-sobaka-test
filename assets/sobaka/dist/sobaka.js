if (!EventTarget.prototype.eventListener) {
    EventTarget.prototype['eventListener'] = function (atype, func, capture) {
        if (typeof arguments[0] === "object" && (!arguments[0].nodeType)) {
            return this.removeEventListener.apply(this, arguments[0]);
        }
        this.addEventListener(String(atype), func, capture);
        return arguments;
    };
}
if (!Element['closestType']) {
    Element.prototype['closestType'] = function (type) {
        let node = this;
        if (node instanceof type) {
            return node;
        }
        else {
            try {
                node = node.parentElement;
                return node.closestType(type);
            }
            catch (err) {
                return null;
            }
        }
    };
}
var articles;
(function (articles) {
    let TBlockTypes;
    (function (TBlockTypes) {
        TBlockTypes["BLOCK_TYPE_TEXT"] = "text";
        TBlockTypes["BLOCK_TYPE_CITATE"] = "citate";
        TBlockTypes["BLOCK_TYPE_NOTE"] = "note";
    })(TBlockTypes = articles.TBlockTypes || (articles.TBlockTypes = {}));
})(articles || (articles = {}));
var articles;
(function (articles) {
    class TArticleForm extends HTMLDivElement {
        connectedCallback() {
            this.addEventListener('click', (ev) => {
                if (ev.target.classList.contains('insert-block')) {
                    ev.target.closestType(articles.TArticleBlockLever)
                        .insertBlockHandler(ev);
                }
            });
        }
        get articleList() {
            if (!this._articleList) {
                this._articleList = this.querySelector('article-block-list, [is="article-block-list"]');
            }
            return this._articleList;
        }
    }
    articles.TArticleForm = TArticleForm;
})(articles || (articles = {}));
customElements.define('article-form', articles.TArticleForm, { extends: 'div' });
var articles;
(function (articles) {
    let Events;
    (function (Events) {
        Events["EV_ADD_BLOCK_COMMAND"] = "abl:add_block_command";
        Events["EV_ADD_BLOCK"] = "abl:add_block";
        Events["EV_MOVE_BLOCK"] = "abl:move_block";
        Events["EV_REMOVE_BLOCK"] = "abl:remove_block";
    })(Events = articles.Events || (articles.Events = {}));
    class TArticleBlockList extends HTMLDivElement {
        connectedCallback() {
            this.addEventListener(Events.EV_ADD_BLOCK, (ev) => {
                this.updateSort();
            });
            this.addEventListener(Events.EV_MOVE_BLOCK, (ev) => {
                this.updateSort();
            });
            this.addEventListener(Events.EV_REMOVE_BLOCK, (ev) => {
                this.updateSort();
            });
            this.eventListener(Events.EV_ADD_BLOCK_COMMAND, (ev) => {
                let data = ev.detail;
                this.createBlock(data.type, data.pos, data.relativeElement);
            });
        }
        createBlock(type, position, relative) {
            let tplid = `template-${type}`;
            let tmpid = `t${Math.floor(Math.random() * 10000) + 1}`;
            let fragment = document.createElement('div');
            fragment.innerHTML = tmpl(tplid, { id: tmpid });
            let block = fragment.childNodes.item(1);
            block.classList.add('invisible');
            let pos;
            if (relative instanceof TArticleBlockList) {
                switch (position) {
                    case articles.TPosition.POS_END:
                        pos = 'beforeend';
                        break;
                    case articles.TPosition.POS_BEGIN:
                        pos = 'afterbegin';
                        break;
                }
                this.insertAdjacentElement(pos, block);
            }
            let attrs = block.createYiiData(tmpid);
            attrs.forEach((obj) => {
                $(this.form).yiiActiveForm('add', obj);
            });
            block.classList.remove('invisible');
            this.dispatchEvent(new CustomEvent(Events.EV_ADD_BLOCK));
            return block;
        }
        updateSort() {
            [].map.call(this.blocks, (block, idx) => {
                block.sort = idx + 1;
            });
        }
        get blocks() {
            return this.querySelectorAll('article-block, [is="article-block"]');
        }
        get form() {
            return this.closest('form');
        }
    }
    articles.TArticleBlockList = TArticleBlockList;
})(articles || (articles = {}));
customElements.define('article-block-list', articles.TArticleBlockList, { extends: 'div' });
var articles;
(function (articles) {
    class TArticleBlock extends HTMLDivElement {
        connectedCallback() {
        }
        get sort() {
            return Number(this.sortInput.value);
        }
        set sort(val) {
            this.sortInput.value = String(val);
        }
        get sortInput() {
            return this.querySelector('input[name*="[sort]"]');
        }
        get idInput() {
            return this.querySelector('input[name*="[id]"]');
        }
        set blockID(val) {
            this.idInput.value = String(val);
        }
        get blockID() {
            return this.idInput.value;
        }
        get blockList() {
            return this.parentElement;
        }
        createYiiData(id) {
            let res = [];
            [].map.call(this.querySelectorAll('[class*="field-article"]'), (el) => {
                let na = el.getAttribute('class').replace('0', id);
                el.setAttribute('class', na);
                let input = el.querySelector('input,textarea');
                input.id = input.id.replace('0', id);
                if ((input instanceof HTMLTextAreaElement)
                    || (input instanceof HTMLInputElement && input.getAttribute('type') == articles.TBlockTypes.BLOCK_TYPE_TEXT)) {
                    let valparam = {};
                    if (input.hasAttribute('max')) {
                        let max = valparam.max = Number(input.getAttribute('max'));
                        let tooLong = input.getAttribute('tooLong');
                        valparam.tooLong = `${tooLong}`;
                    }
                    valparam.skipOnEmpty = 1;
                    let containerClass;
                    for (let cls of el.classList.entries()) {
                        if (cls[1].search('field-article')) {
                            containerClass = cls[1];
                            break;
                        }
                    }
                    let obj = {
                        id: input.id,
                        name: input.getAttribute('name').match(/.+\[.+\]\[(.+)\]/)[1],
                        container: `.${containerClass}`,
                        input: `#${input.id}`,
                        error: '.invalid-feedback',
                        validate: function (attribute, value, messages, deferred, $form) {
                            yii.validation.string(value, messages, valparam);
                        }
                    };
                    res.push(obj);
                }
            });
            return res;
        }
    }
    articles.TArticleBlock = TArticleBlock;
})(articles || (articles = {}));
customElements.define('article-block', articles.TArticleBlock, { extends: 'div' });
var articles;
(function (articles) {
    let TPosition;
    (function (TPosition) {
        TPosition["POS_BEGIN"] = "begin";
        TPosition["POS_END"] = "end";
        TPosition["POS_BEFORE"] = "before";
        TPosition["POS_AFTER"] = "after";
    })(TPosition = articles.TPosition || (articles.TPosition = {}));
    class TAddLever extends HTMLDivElement {
        constructor() {
            super(...arguments);
            this._posValue = undefined;
            this._typeValue = undefined;
        }
        connectedCallback() {
            this.buttonCancel.eventListener('click', (ev) => {
                ev.preventDefault();
                TAddLever.destroy();
            });
            this.buttonOk.eventListener('click', (ev) => {
                ev.preventDefault();
                this.createBlock();
                TAddLever.destroy();
            });
            this.posInputs.forEach((input) => {
                input.eventListener('change', (ev) => {
                    this.dispatchEvent(new CustomEvent('ab:change', { detail: this.querySelector('input[name="btnpos"]:checked') }));
                });
            });
            this.typeInputs.forEach((input) => {
                input.eventListener('change', (ev) => {
                    this.dispatchEvent(new CustomEvent('ab:change', { detail: this.querySelector('input[name="btntype"]:checked') }));
                });
            });
            this.eventListener('ab:change', (ev) => {
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
        get buttonCancel() {
            return this.querySelector('.btn-cancel');
        }
        get buttonOk() {
            return this.querySelector('.btn-ok');
        }
        get posInputs() {
            return this.querySelectorAll('input[name="btnpos"]');
        }
        get typeInputs() {
            return this.querySelectorAll('input[name="btntype"]');
        }
        get mainer() {
            return document.querySelector('article-form, [is="article-form"]');
        }
        static create(ev) {
            let parent = ev.target;
            TAddLever.destroy();
            parent.style.position = 'relative';
            document.body.insertAdjacentHTML('beforeend', document.querySelector('#template_add_lever_main').innerHTML);
            let isset = TAddLever.find();
            if (isset instanceof HTMLElement) {
                isset.style.left = parent.offsetLeft + parent.offsetWidth + 10 + 'px';
                isset.style.top = parent.offsetTop + 'px';
                isset.style.opacity = '1';
            }
            tooltips(parent);
        }
        static find() {
            return document.getElementById('add_lever');
        }
        static destroy() {
            let isset = TAddLever.find();
            if (isset instanceof HTMLElement) {
                delete isset.parentElement.removeChild(isset);
            }
        }
    }
    articles.TAddLever = TAddLever;
    class TMainAddLever extends TAddLever {
        createBlock() {
            let data = {
                type: this._typeValue,
                pos: this._posValue,
                relativeElement: this.mainer.articleList
            };
            this.mainer.articleList.dispatchEvent(new CustomEvent(articles.Events.EV_ADD_BLOCK_COMMAND, { detail: data }));
        }
    }
    TMainAddLever._tpl = 'template_add_lever_main';
    articles.TMainAddLever = TMainAddLever;
    class TBlockAddLever extends TAddLever {
        createBlock() {
        }
    }
    TBlockAddLever._tpl = 'template_add_lever_second';
    articles.TBlockAddLever = TBlockAddLever;
})(articles || (articles = {}));
customElements.define('block-add-lever-main', articles.TMainAddLever, { extends: 'div' });
customElements.define('block-add-lever-second', articles.TBlockAddLever, { extends: 'div' });
var articles;
(function (articles) {
    class TArticleBlockLever extends HTMLDivElement {
        insertBlockHandler(ev) {
            articles.TMainAddLever.create(ev);
        }
    }
    articles.TArticleBlockLever = TArticleBlockLever;
})(articles || (articles = {}));
customElements.define('article-block-lever', articles.TArticleBlockLever, { extends: 'div' });
let LanguageChoose = function () {
    this.element = document.querySelector('.lang-choose');
    [].map.call(this.element.querySelectorAll('.flag'), (el) => {
        el.addEventListener('click', (ev) => {
            let lang = ev.target.getAttribute('data-lang');
            cookie.write('sobaka.lang', lang);
            location.reload();
        });
    });
};
var mf;
(function (mf) {
    class TControlBlock extends HTMLDivElement {
        constructor() {
            super();
            this._lever = document.createElement('dd');
            this.appendChild(this._lever);
            this._lever.addEventListener('click', (ev) => {
                if (this.classList.contains('expanded')) {
                    this.classList.remove('expanded');
                }
                else {
                    this.classList.add('expanded');
                }
            });
        }
        connectedCallback() {
        }
    }
    mf.TControlBlock = TControlBlock;
})(mf || (mf = {}));
customElements.define('mf-control-block', mf.TControlBlock, { extends: 'div' });
let tooltips = (el) => {
    const tooltipTriggerList = el.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
};
document.addEventListener('DOMContentLoaded', () => {
    LanguageChoose();
    $('input[name*="figureFile"][type="file"]').on('change', (ev) => {
        setTimeout(() => {
            if (ev.currentTarget.classList.contains('is-invalid')) {
                $(ev.target)
                    .closest('[class*="field-figure-figurefile"]')
                    .children('.invalid-feedback')
                    .show();
            }
            else {
                $(ev.target)
                    .closest('[class*="field-figure-figurefile"]')
                    .children('.invalid-feedback')
                    .hide();
            }
        }, 600);
    });
    tooltips(document);
});
