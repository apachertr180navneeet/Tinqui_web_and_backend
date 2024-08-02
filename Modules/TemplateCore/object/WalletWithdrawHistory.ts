import { PsObject } from "./core/PsObject";

export default class WalletWithdrawHistory extends PsObject<WalletWithdrawHistory> {
    id: string = "";
    withdraw_amount: string = "";
    currency: string = "";
    withdraw_status: string = "";
    request_date: string = "";
    processing_date: string = "";
    decline_reason: string = "";
    notes: string = "";

    init(
        id: string,
        withdraw_amount: string,
        currency: string,
        withdraw_status: string,
        request_date: string,
        processing_date: string,
        decline_reason: string,
        notes: string
    ) {
        this.id = id;
        this.withdraw_amount = withdraw_amount;
        this.currency = currency;
        this.withdraw_status = withdraw_status;
        this.request_date = request_date;
        this.processing_date = processing_date;
        this.decline_reason = decline_reason;
        this.notes = notes;

        return this;
    }
    getPrimaryKey(): string {
        return this.id;
    }

    toMap(object: WalletWithdrawHistory): any {
        const map = {};
        map["id"] = object.id;
        map["withdraw_amount"] = object.withdraw_amount;
        map["currency"] = object.currency;
        map["withdraw_status"] = object.withdraw_status;
        map["request_date"] = object.request_date;
        map["processing_date"] = object.processing_date;
        map["decline_reason"] = object.decline_reason;
        map["notes"] = object.notes;

        return map;
    }

    toMapList(objectList: WalletWithdrawHistory[]): any[] {
        // console.log("objectList", objectList);
        const mapList: any[] = [];
        for (let i = 0; i < objectList.length; i++) {
            if (objectList[i] != null) {
                mapList.push(this.toMap(objectList[i]));
            }
        }

        return mapList;
    }

    fromMap(obj: any): WalletWithdrawHistory {
        if (obj.id != undefined) {
        }
        return new WalletWithdrawHistory().init(
            obj.id,
            obj.withdraw_amount,
            obj.currency,
            obj.withdraw_status,
            obj.request_date,
            obj.processing_date,
            obj.decline_reason,
            obj.notes
        );
    }

    fromMapList(objList: any[]): WalletWithdrawHistory[] {
        const mapList: any[] = [];
        for (const obj of objList as Array<WalletWithdrawHistory>) {
            if (obj != null) {
                mapList.push(this.fromMap(obj));
            }
        }

        return mapList;
    }
}
