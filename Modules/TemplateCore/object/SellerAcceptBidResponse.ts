import DisputedBidHolder from "./DisputedBidsHolder";
import { PsObject } from "./core/PsObject";

export default class BidAcceptResponse extends PsObject<BidAcceptResponse> {
    id: string = "";
    userId: string = "";
    currency: string = "";
    walletBalance: string = "";
    amountOnHold: string = "";
    rechargeDate: string = "";
    createdAt: string = "";
    updatedAt: string = "";
    bidDetails: DisputedBidHolder[] = [new DisputedBidHolder()];

    init(
        id: string,
        userId: string,
        currency: string,
        walletBalance: string,
        amountOnHold: string,
        rechargeDate: string,
        createdAt: string,
        updatedAt: string,
        bidDetails: DisputedBidHolder[]
    ) {
        this.id = id;
        this.userId = userId;
        this.currency = currency;
        this.walletBalance = walletBalance;
        this.amountOnHold = amountOnHold;
        this.rechargeDate = rechargeDate;
        this.createdAt = createdAt;
        this.updatedAt = updatedAt;
        this.bidDetails = bidDetails;

        return this;
    }

    getPrimaryKey(): string {
        return this.id;
    }

    fromMap(obj: any) {
        return new BidAcceptResponse().init(
            obj.id,
            obj.userId,
            obj.currency,
            obj.walletBalance,
            obj.amountOnHold,
            obj.rechargeDate,
            obj.createdAt,
            obj.updatedAt,
            new DisputedBidHolder().fromMapList(obj.bidDetails),
        );
    }

    fromMapList(objList: any[]): BidAcceptResponse[] {
        const BuyNowHolderList: BidAcceptResponse[] = [];
        for (let index = 0; index < objList.length; index++) {
            const obj = objList[index];
            if (obj != null) {
                BuyNowHolderList.push(this.fromMap(obj));
            }
        }

        return BuyNowHolderList;
    }

    toMap(object: BidAcceptResponse): any {
        const map = {};
        map["id"] = object.id;
        map["user_id"] = object.userId;
        map["currency"] = object.currency;
        map["wallet_balance"] = object.walletBalance;
        map["amount_on_hold"] = object.amountOnHold;
        map["recharge_date"] = object.rechargeDate;
        map["created_at"] = object.createdAt;
        map["updated_at"] = object.updatedAt;
        map["bidDetails"] = new DisputedBidHolder().toMapList(object.bidDetails);

        return map;
    }

    toMapList(objectList: BidAcceptResponse[]): any[] {
        const mapList: any[] = [];
        for (let i = 0; i < objectList.length; i++) {
            if (objectList[i] != null) {
                mapList.push(this.toMap(objectList[i]));
            }
        }

        return mapList;
    }
}
