/* ts-ignore */
import { PsObject } from "@templateCore/object/core/PsObject";

export default class BuyWithStripe extends PsObject<BuyWithStripe> {
   message: string = "";
   status: string = "";

    init(
        message: string,
        status: string,
    ) {
      this.message = message;
      this.status = status;

        return this;
    }

    getPrimaryKey(): string {
        return this.status;
    }

    toMap(object: BuyWithStripe): any {
        const map = {};

      map["message"] = object.message;
      map["status"] = object.status;

        return map;
    }

    toMapList(objectList: BuyWithStripe[]): any[] {
        const mapList: any[] = [];
        for (let i = 0; i < objectList.length; i++) {
                mapList.push(this.toMap(objectList[i]));
        }

        return mapList;
    }

    fromMap(obj: any) {
        return new BuyWithStripe().init(
            obj.message,
            obj.status,
        );
    }

    fromMapList(objList: any[]): BuyWithStripe[] {
        const auctionItemList: BuyWithStripe[] = [];
        for (const obj of objList as Array<BuyWithStripe>) {
            if (obj != null) {
                auctionItemList.push(this.fromMap(obj));
            }
        }

        return auctionItemList;
    }
}
