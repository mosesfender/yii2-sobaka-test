module articles {
    export enum TBlockTypes {
        BLOCK_TYPE_TEXT = 'text',
        BLOCK_TYPE_CITATE = 'citate',
        BLOCK_TYPE_NOTE = 'note',
    }
 
    export interface IValidateObject {
        id: string,
        name: string,
        container: string,
        input: string,
        error: string,
        validate: unknown,
        message: string,
        skipOnEmpty: number
    }
    
    export interface IValidStrParam {
        max?: number,
        min?: number,
        tooLong?: string,
        tooShort?: string,
        skipOnEmpty?: number,
        message?: string,
    }
}