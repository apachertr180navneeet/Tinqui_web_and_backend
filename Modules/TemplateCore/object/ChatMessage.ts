import { PsObject } from "./core/PsObject";

export default class ChatMessage extends PsObject<ChatMessage> {

    id: string = '';
    itemId: string = '';
    sessionId: string = '';
    key: string = '';
    message: string = '';
    type: Number = 0;
    sendByUserId: string = '';
    offerStatus: Number = 0;
    addedDate: string = '';
    isSold: Boolean = false;
    isUserBought: Boolean = false;
    dateTimeString: string = '';
    dateString: string = '';
    timeString: string = '';
    amount: string = "";
    isPaymentComplete: string = "";
    currencySymbol: string = "";
    isAuctionChat: number = 0;
    bidAcceptedUserId: string = '';
    bidderName: string = '';
    bidDetailId: string = '';
    senderId: string = '';


    init(
        id: string,
        itemId: string,
        sessionId: string,
        key: string,
        message: string,
        type: Number,
        sendByUserId: string,
        offerStatus: Number,
        addedDate: string,
        isSold: Boolean,
        isUserBought: Boolean,
        dateTimeString: string,
        dateString: string,
        timeString: string,
        amount: string,
        isPaymentComplete: string,
        currencySymbol: string,
        isAuctionChat: number,
        bidAcceptedUserId: string,
        bidderName: string,
        bidDetailId: string,
        senderId: string,
    ) {
        this.id = id;
        this.itemId = itemId;
        this.sessionId = sessionId;
        this.key = key;
        this.message = message;
        this.type = type;
        this.sendByUserId = sendByUserId;
        this.offerStatus = offerStatus;
        this.addedDate = addedDate;
        this.isSold = isSold;
        this.isUserBought = isUserBought;
        this.dateTimeString = dateTimeString;
        this.dateString = dateString;
        this.timeString = timeString;
        this.amount = amount;
        this.isPaymentComplete = isPaymentComplete;
        this.currencySymbol = currencySymbol;
        this.isAuctionChat = isAuctionChat;
        this.bidAcceptedUserId = bidAcceptedUserId;
        this.bidderName = bidderName;
        this.bidDetailId = bidDetailId;
        this.senderId = senderId;


        return this;

    }

    getPrimaryKey(): string {
        return this.itemId;
    }

    fromMap(obj: any): ChatMessage {
        return new ChatMessage().init(
            obj.id,
            obj.itemId,
            obj.sessionId,
            obj.key,
            obj.message,
            obj.type,
            obj.sendByUserId,
            obj.offerStatus,
            obj.addedDate,
            obj.isSold,
            obj.isUserBought,
            obj.dateTimeString,
            obj.dateString,
            obj.timeString,
            obj.amount ,
            obj.isPaymentComplete,
            obj.currencySymbol,
            obj.isAuctionChat ,
            obj.bidAcceptedUserId,
            obj.bidderName,
            obj.bidDetailId,
            obj.senderId 
        );
    }

    fromMapList(objList: any[]): ChatMessage[] {
        const chat: ChatMessage[] = [];
        for (const obj in objList) {
            if (obj != null) {
                chat.push(this.fromMap(obj));
            }
        }

        return chat;
    }

    toMap(object: ChatMessage): any {
        const map = {};

        map['id'] = object.id;
        map['itemId'] = object.itemId;
        map['sessionId'] = object.sessionId;
        map['key'] = object.key;
        map['message'] = object.message;
        map['type'] = object.type;
        map['sendByUserId'] = object.sendByUserId;
        map['offerStatus'] = object.offerStatus;
        map['addedDate'] = object.addedDate;
        map['isSold'] = object.isSold;
        map['isUserBought'] = object.isUserBought;
        map['dateTimeString'] = object.dateTimeString;
        map['dateString'] = object.dateString;
        map['timeString'] = object.timeString;
        map['amount'] = object.amount;
        map['isPaymentComplete'] = object.isPaymentComplete;
        map['currencySymbol'] = object.currencySymbol;
        map['isAuctionChat'] = object.isAuctionChat;
        map['bidAcceptedUserId'] = object.bidAcceptedUserId;
        map['bidderName'] = object.bidderName;
        map['bidDetailId'] = object.bidDetailId;
        map['senderId'] = object.senderId;



        return map;
    }

    toMapList(objectList: ChatMessage[]): any[] {
        const mapList: any[] = [];
        for (let i = 0; i < objectList.length; i++) {
            if (objectList[i] != null) {
                mapList.push(this.toMap(objectList[i]));
            }
        }

        return mapList;
    }
}
