import DisputedBidHolder from "./DisputedBidsHolder";
import UserWalletLog from "./UserWalletLog";
import { PsObject } from "./core/PsObject";

export default class BuyNowHolder extends PsObject<BuyNowHolder> {
    id: string = "";
    user_id: string = "";
    currency: string = "";
    wallet_balance: string = "";
    amount_on_hold: string = "";
    recharge_date: string = "";
    created_at: string = "";
    updated_at: string = "";
    // walletLog: UserWalletLog[] = [new UserWalletLog()];
    currentbidDetails: DisputedBidHolder = new DisputedBidHolder();

    init(
        id: string,
        user_id: string,
        currency: string,
        wallet_balance: string,
        amount_on_hold: string,
        recharge_date: string,
        created_at: string,
        updated_at: string,
        // walletLog: UserWalletLog[],
        currentbidDetails: DisputedBidHolder
    ) {
        this.id = id;
        this.user_id = user_id;
        this.currency = currency;
        this.wallet_balance = wallet_balance;
        this.amount_on_hold = amount_on_hold;
        this.recharge_date = recharge_date;
        this.created_at = created_at;
        this.updated_at = updated_at;
        // this.walletLog = walletLog;
        this.currentbidDetails = currentbidDetails

        return this;
    }

    getPrimaryKey(): string {
        return this.id;
    }

    fromMap(obj: any) {
        return new BuyNowHolder().init(
            obj.id,
            obj.user_id,
            obj.currency,
            obj.wallet_balance,
            obj.amount_on_hold,
            obj.recharge_date,
            obj.created_at,
            obj.updated_at,
            // new UserWalletLog().fromMapList(obj.walletLog),
            new DisputedBidHolder().fromMap(obj.currentbidDetails),
        );
    }

    fromMapList(objList: any[]): BuyNowHolder[] {
        const BuyNowHolderList: BuyNowHolder[] = [];
        for (let index = 0; index < objList.length; index++) {
            const obj = objList[index];
            if (obj != null) {
                BuyNowHolderList.push(this.fromMap(obj));
            }
        }

        return BuyNowHolderList;
    }

    toMap(object: BuyNowHolder): any {
        const map = {};
        map["id"] = object.id;
        map["user_id"] = object.user_id;
        map["currency"] = object.currency;
        map["wallet_balance"] = object.wallet_balance;
        map["amount_on_hold"] = object.amount_on_hold;
        map["recharge_date"] = object.recharge_date;
        map["created_at"] = object.created_at;
        map["updated_at"] = object.updated_at;
        // map["walletLog"] = new UserWalletLog().toMapList(object.walletLog);
        map["currentbidDetails"] = new DisputedBidHolder().toMap(object.currentbidDetails);

        return map;
    }

    toMapList(objectList: BuyNowHolder[]): any[] {
        const mapList: any[] = [];
        for (let i = 0; i < objectList.length; i++) {
            if (objectList[i] != null) {
                mapList.push(this.toMap(objectList[i]));
            }
        }

        return mapList;
    }
}
