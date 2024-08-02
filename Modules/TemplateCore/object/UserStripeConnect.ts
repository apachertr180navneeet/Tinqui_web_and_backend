import { PsObject } from "./core/PsObject";

export default class UserStripeConnect extends PsObject<UserStripeConnect> {
    accountId: string = "";
    clientSecret: string = "";
    onboardingStatus: string = "";
    chargesEnabled: string = "";
    transfersEnabled: string = "";
    payoutsEnabled: string = "";

    init(
        accountId: string,
        clientSecret: string,
        onboardingStatus: string,
        chargesEnabled: string,
        transfersEnabled: string,
        payoutsEnabled: string
    ) {
        this.accountId = accountId;
        this.clientSecret = clientSecret;
        this.onboardingStatus = onboardingStatus;
        this.chargesEnabled = chargesEnabled;
        this.transfersEnabled = transfersEnabled;
        this.payoutsEnabled = payoutsEnabled;

        return this;
    }
    getPrimaryKey(): string {
        return this.clientSecret;
    }

    toMap(object: UserStripeConnect): any {
        const map = {};
        map["account_id"] = object.accountId;
        map["client_secret"] = object.clientSecret;
        map["onboarding_status"] = object.onboardingStatus;
        map["charges_enabled"] = object.chargesEnabled;
        map["transfers_enabled"] = object.transfersEnabled;
        map["payouts_enabled"] = object.payoutsEnabled;

        return map;
    }

    toMapList(objectList: UserStripeConnect[]): any[] {
        const mapList: any[] = [];
        for (let i = 0; i < objectList.length; i++) {
            if (objectList[i] != null) {
                mapList.push(this.toMap(objectList[i]));
            }
        }

        return mapList;
    }

    fromMap(obj: any): UserStripeConnect {
        return new UserStripeConnect().init(
            obj.account_id,
            obj.client_secret,
            obj.onboarding_status,
            obj.charges_enabled,
            obj.transfers_enabled,
            obj.payouts_enabled
        );
    }

    fromMapList(objList: any[]): UserStripeConnect[] {
        const StripeConnect: UserStripeConnect[] = [];
        for (const obj of objList as Array<UserStripeConnect>) {
            if (obj != null) {
                StripeConnect.push(this.fromMap(obj));
            }
        }

        return StripeConnect;
    }
}
