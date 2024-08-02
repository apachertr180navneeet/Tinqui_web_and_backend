import { PsObject } from "./core/PsObject";
import UserWalletLog from "./UserWalletLog";

export default class WalletPaidHistory extends PsObject<WalletPaidHistory> {
    Id: string = "";
    userId: string = "";
    currency: string = "";
    walletBalance: string;
    holdAmount: string;
    rechargeDate: string = "";
    createdAt: string = "";
    updatedAt: string = "";

    userWalletLog: UserWalletLog[] = [new UserWalletLog()];
    // UserWalletLog = new UserWalletLog();

    init(
        Id: string,
        userId: string,
        currency: string,
        walletBalance: string,
        holdAmount: string,
        rechargeDate: string,
        createdAt: string,
        updatedAt: string,
        userWalletLog: UserWalletLog[]
    ) {
        this.Id = Id;
        this.userId = userId;
        this.currency = currency;
        this.walletBalance = walletBalance;
        this.holdAmount = holdAmount;
        this.rechargeDate = rechargeDate;
        this.createdAt = createdAt;
        this.updatedAt = updatedAt;

        this.userWalletLog = userWalletLog;

        return this;
    }
    getPrimaryKey(): string {
        return this.Id;
    }

    toMap(object: WalletPaidHistory): any {
        const map = {};
        map["id"] = object.Id;
        map["user_id"] = object.userId;
        map["currency"] = object.currency;
        map["wallet_balance"] = object.walletBalance;
        map["amount_on_hold"] = object.holdAmount;
        map["recharge_date"] = object.rechargeDate;
        map["created_at"] = object.createdAt;
        map["updated_at"] = object.updatedAt;

        map["wallet_logs"] = new UserWalletLog().toMapList(
            object.userWalletLog
        );

        return map;
    }

    toMapList(objectList: WalletPaidHistory[]): any[] {
        const mapList: any[] = [];
        for (let i = 0; i < objectList.length; i++) {
            if (objectList[i] != null) {
                mapList.push(this.toMap(objectList[i]));
            }
        }

        return mapList;
    }

    fromMap(obj: any): WalletPaidHistory {
        return new WalletPaidHistory().init(
            obj.id,
            obj.user_id,
            obj.currency,
            obj.wallet_balance,
            obj.amount_on_hold,
            obj.recharge_date,
            obj.created_at,
            obj.updated_at,
            new UserWalletLog().fromMapList(obj.wallet_logs)
        );
    }

    fromMapList(objList: any[]): WalletPaidHistory[] {
        const userWallet: WalletPaidHistory[] = [];
        for (const obj of objList as Array<WalletPaidHistory>) {
            if (obj != null) {
                userWallet.push(this.fromMap(obj));
            }
        }

        return userWallet;
    }
}
