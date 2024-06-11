/*
 * Copyright © Sergey Siunov. 2024
 * email: <sergey@siunov.ru>
 */

interface EventTarget
{
    eventListener(atype: string | object, func?: EventListenerOrEventListenerObject, capture?: any);
}

if (!EventTarget.prototype.eventListener) {
    EventTarget.prototype['eventListener'] = function (
        atype: string | object, func?: EventListenerOrEventListenerObject, capture?: any) {
        if (typeof arguments[0] === "object" && (!arguments[0].nodeType)) {
            return (this as HTMLElement).removeEventListener.apply(this, arguments[0]);
        }
        (this as HTMLElement).addEventListener(String(atype), func, capture);
        return arguments;
    };
}

interface Element
{
    /**
     * Находит элемент с указанным типом в иерархии объектов вверх от текщего элемента.
     * @param type Искомый тип объекта (имя конструктора)
     */
    closestType(type: any): Element | null;
}

if (!Element['closestType']) {
    Element.prototype['closestType'] = function (type: any) {
        let node = this as Element;
        if (node instanceof type) {
            return node;
        } else {
            try {
                node = node.parentElement;
                return node.closestType(type);
            } catch (err) {
                return null;
            }
        }
    }
}