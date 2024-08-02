import { PsObject } from "@templateCore/object/core/PsObject";

export default class UserWalletLog extends PsObject<UserWalletLog> {
    Id: string = "";
    walletId: string = "";
    log_type: string = "";
    amountAdded: string = "";
    amountDeducted: string = "";
    amountOnHold: string = "";
    currency: string = "";
    oldBalance: string = "";
    paymentType: string = "";
    paymentStatus: string = "";
    transactionId: string = "";
    paidAt: string = "";
    createdAt: string = "";
    updatedAt: string = "";

    init(
        Id: string,
        walletId: string,
        log_type: string,
        amountAdded: string,
        amountDeducted: string,
        amountOnHold: string,
        currency: string,
        oldBalance: string,
        paymentType: string,
        paymentStatus: string,
        transactionId: string,
        paidAt: string,
        createdAt: string,
        updatedAt: string
    ) {
        this.Id = Id;
        this.walletId = walletId;
        this.log_type = log_type;
        this.amountAdded = amountAdded;
        this.amountDeducted = amountDeducted;
        this.amountOnHold = amountOnHold;
        this.currency = currency;
        this.oldBalance = oldBalance;
        this.paymentType = paymentType;
        this.createdAt = createdAt;
        this.updatedAt = updatedAt;
        this.paymentStatus = paymentStatus;
        this.transactionId = transactionId;
        this.paidAt = paidAt;

        return this;
    }

    getPrimaryKey(): string {
        return this.Id;
    }

    toMap(object: UserWalletLog): any {
        const map = {};

        map["id"] = object.Id;
        map["users_wallet_id"] = object.walletId;
        map["log_type"] = object.log_type;
        map["amount_added"] = object.amountAdded;
        map["amount_deducted"] = object.amountDeducted;
        map["on_hold_amount"] = object.amountOnHold;
        map["currency"] = object.currency;
        map["old_balance"] = object.oldBalance;
        map["payment_type"] = object.paymentType;
        map["payment_status"] = object.paymentStatus;
        map["txn_id"] = object.transactionId;
        map["paid_at"] = object.paidAt;
        map["created_at"] = object.createdAt;
        map["updated_at"] = object.updatedAt;

        return map;
    }

    toMapList(objectList: UserWalletLog[]): any[] {
        const mapList: any[] = [];
        for (let i = 0; i < objectList.length; i++) {
            if (objectList[i] != null) {
                mapList.push(this.toMap(objectList[i]));
            }
        }

        return mapList;
    }

    fromMap(obj: any) {
        return new UserWalletLog().init(
            obj.id,
            obj.users_wallet_id,
            obj.log_type,
            obj.amount_added,
            obj.amount_deducted,
            obj.on_hold_amount,
            obj.currency,
            obj.old_balance,
            obj.payment_type,
            obj.payment_status,
            obj.txn_id,
            obj.paid_at,
            obj.created_at,
            obj.updated_at
        );
    }

    fromMapList(objList: any[]): UserWalletLog[] {
        const walletLog: UserWalletLog[] = [];
        for (let index = 0; index < objList.length; index++) {
            const obj = objList[index];
            if (obj != null) {
                walletLog.push(this.fromMap(obj));
            }
        }

        return walletLog;
    }
}
