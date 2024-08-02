import { PsObject } from "./core/PsObject";

export default class MolliePaymentUrl extends PsObject<MolliePaymentUrl> {
    url: string = "";

    init(url: string) {
        this.url = url;

        return this;
    }
    getPrimaryKey(): string {
        return this.url;
    }

    toMap(object: MolliePaymentUrl): any {
        const map = {};
        map["url"] = object.url;

        return map;
    }

    toMapList(objectList: MolliePaymentUrl[]): any[] {
        const mapList: any[] = [];
        for (let i = 0; i < objectList.length; i++) {
            if (objectList[i] != null) {
                mapList.push(this.toMap(objectList[i]));
            }
        }

        return mapList;
    }

    fromMap(obj: any): MolliePaymentUrl {
        return new MolliePaymentUrl().init(obj.url);
    }

    fromMapList(objList: any[]): MolliePaymentUrl[] {
        const userWallet: MolliePaymentUrl[] = [];
        for (const obj of objList as Array<MolliePaymentUrl>) {
            if (obj != null) {
                userWallet.push(this.fromMap(obj));
            }
        }

        return userWallet;
    }
}
