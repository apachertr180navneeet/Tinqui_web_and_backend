import PsConst from '@templateCore/object/constant/ps_constants';

export default class ChatPrameterHolder {


    addedDateTimeStamp: Number = 0;
    id: string = '';
    itemId: string = '';
    message: string = '';
    sendByUserId: string = '';
    sessionId: string = '';
    type: Number = 0;
    sellerId?: string = '';


    ChatParameterHolder() {
        this.addedDateTimeStamp = Math.floor(Date.now());
        this.id = '';
        this.itemId = '';
        this.message = 'hi';
        this.sendByUserId = '';
        this.sessionId = '';
        this.type = PsConst.CHAT_TYPE_TEXT;
        this.sellerId = '';
        return this;


    }
    ChatAcceptParameterHolder(): ChatPrameterHolder {
        this.addedDateTimeStamp = Math.floor(Date.now());
        this.id = '';
        this.itemId = '';
        this.message = '';
        this.sendByUserId = '';
        this.sessionId = '';
        this.type = PsConst.CHAT_TYPE_ACCEPT;
        this.sellerId = '';
        return this;


    }

    toMap(): {} {
        const map = {};
        map['item_id'] = this.itemId;
        map['send_by_user_id'] = this.sendByUserId;
        map['message'] = this.message;
        map['type'] = this.type;



        return map;
    }
}