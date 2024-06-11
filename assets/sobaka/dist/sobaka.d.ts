declare type tmpl = {
    arg: string;
};
declare function tmpl(template: string, data?: Object): any;
interface EventTarget {
    eventListener(atype: string | object, func?: EventListenerOrEventListenerObject, capture?: any): any;
}
interface Element {
    closestType(type: any): Element | null;
}
declare module articles {
    enum TBlockTypes {
        BLOCK_TYPE_TEXT = "text",
        BLOCK_TYPE_CITATE = "citate",
        BLOCK_TYPE_NOTE = "note"
    }
    interface IValidateObject {
        id: string;
        name: string;
        container: string;
        input: string;
        error: string;
        validate: unknown;
        message: string;
        skipOnEmpty: number;
    }
    interface IValidStrParam {
        max?: number;
        min?: number;
        tooLong?: string;
        tooShort?: string;
        skipOnEmpty?: number;
        message?: string;
    }
}
declare module articles {
    class TArticleForm extends HTMLDivElement {
        connectedCallback(): void;
        private _articleList;
        get articleList(): TArticleBlockList;
    }
}
declare module articles {
    interface IAddBlockData {
        type: string;
        pos: string;
        relativeElement: HTMLElement;
    }
    enum Events {
        EV_ADD_BLOCK_COMMAND = "abl:add_block_command",
        EV_ADD_BLOCK = "abl:add_block",
        EV_MOVE_BLOCK = "abl:move_block",
        EV_REMOVE_BLOCK = "abl:remove_block"
    }
    class TArticleBlockList extends HTMLDivElement {
        connectedCallback(): void;
        createBlock(type: string, position: string, relative: HTMLElement): TArticleBlock;
        updateSort(): void;
        get blocks(): NodeList;
        get form(): HTMLFormElement;
    }
}
declare module articles {
    class TArticleBlock extends HTMLDivElement {
        connectedCallback(): void;
        get sort(): number;
        set sort(val: number);
        get sortInput(): HTMLInputElement;
        get idInput(): HTMLInputElement;
        set blockID(val: string | number);
        get blockID(): string;
        get blockList(): TArticleBlockList;
        createYiiData(id: string): Array<IValidateObject>;
    }
}
declare module articles {
    enum TPosition {
        POS_BEGIN = "begin",
        POS_END = "end",
        POS_BEFORE = "before",
        POS_AFTER = "after"
    }
    abstract class TAddLever extends HTMLDivElement {
        static _tpl: string;
        protected _posValue: string;
        protected _typeValue: string;
        connectedCallback(): void;
        protected abstract createBlock(): any;
        get buttonCancel(): HTMLElement;
        get buttonOk(): HTMLElement;
        get posInputs(): NodeList;
        get typeInputs(): NodeList;
        get mainer(): TArticleForm;
        static create(ev: MouseEvent): void;
        static find(): HTMLElement;
        static destroy(): void;
    }
    class TMainAddLever extends TAddLever {
        static _tpl: string;
        protected createBlock(): void;
    }
    class TBlockAddLever extends TAddLever {
        static _tpl: string;
        protected createBlock(): void;
    }
}
declare module articles {
    class TArticleBlockLever extends HTMLDivElement {
        insertBlockHandler(ev: MouseEvent): void;
    }
}
declare let LanguageChoose: () => void;
declare module mf {
    class TControlBlock extends HTMLDivElement {
        protected _lever: HTMLElement;
        constructor();
        connectedCallback(): void;
    }
}
declare let tooltips: (el: Element | Document) => void;
