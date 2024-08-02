import { PsObject } from "@templateCore/object/core/PsObject";
import HistoryData from "./HistoryData";

export default class SalePurchaseHistory extends PsObject<SalePurchaseHistory> {
    purchaseData: HistoryData[] = [new HistoryData()];
    saleData: HistoryData[] = [new HistoryData()];

    init(purchaseData: HistoryData[], saleData: HistoryData[]) {
        this.purchaseData = purchaseData;
        this.saleData = saleData;
        return this;
    }

    toMap(object: SalePurchaseHistory): any {
        const map = {};
        map["purchaseData"] = new HistoryData().toMapList(object.purchaseData);
        map["saleData"] = new HistoryData().toMapList(object.saleData);

        return map;
    }

    toMapList(objectList: SalePurchaseHistory[]): any[] {
        const mapList: any[] = [];
        for (let i = 0; i < objectList.length; i++) {
            if (objectList[i] != null) {
                mapList.push(this.toMap(objectList[i]));
            }
        }

        return mapList;
    }

    fromMap(obj: any) {
        return new SalePurchaseHistory().init(
            new HistoryData().fromMapList(obj.purchaseData) || [],
            new HistoryData().fromMapList(obj.saleData) || []
        );
    }

    fromMapList(objList: any[]): SalePurchaseHistory[] {
        const list: SalePurchaseHistory[] = [];
        for (const obj of objList as Array<SalePurchaseHistory>) {
            if (obj != null) {
                list.push(this.fromMap(obj));
            }
        }

        return list;
    }
}
