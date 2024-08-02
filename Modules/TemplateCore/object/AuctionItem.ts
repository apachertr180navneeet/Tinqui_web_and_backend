/* ts-ignore */
import { PsObject } from "@templateCore/object/core/PsObject";
import DefaultPhoto from "./DefaultPhoto";
import Category from "./Category";
import SubCategory from "./SubCategory";
import ItemCurrency from "./ItemCurrency";
import ItemLocation from "./ItemLocation";
import ItemLocationTownship from "./ItemLocationTownship";
import ProductRelation from "./ProductRelation";
import User from "./User";
import Vendor from "./Vendor";

export default class AuctionItem extends PsObject<AuctionItem> {
    id: string = "";
    catId: string = "";
    subCatId: string = "";
    itemCurrencyId: string = "";
    itemLocationId: string = "";
    itemLocationTownshipId: string = "";
    description: string = "";
    isWarrantyItem: string | number = "";
    preferredPayment: string = "";
    price: string = "";
    percent: string = "";
    phone: string = "";
    isSoldOut: string = "";
    title: string = "";
    lat: string = "";
    lng: string = "";
    status: string = "";
    addedDate: string = "";
    addedUserId: string = "";
    isDiscount: string = "";
    touchCount: string = "";
    favouriteCount: string = "";
    isPaid: string = "";
    dynamicLink: string = "";
    addedDateStr: string = "";
    paidStatus: string = "";
    photoCount: string = "";
    defaultPhoto: DefaultPhoto = new DefaultPhoto();
    video: DefaultPhoto = new DefaultPhoto();
    videoThumbnail: DefaultPhoto = new DefaultPhoto();
    category: Category = new Category();
    subCategory: SubCategory = new SubCategory();
    itemCurrency: ItemCurrency = new ItemCurrency();
    itemLocation: ItemLocation = new ItemLocation();
    itemLocationTownship: ItemLocationTownship = new ItemLocationTownship();
    user: User = new User();
    vendor: Vendor = new Vendor();
    isFavourited: string = "";
    isOwner: string = "";
    originalPrice: string = "";
    adType: string = "";
    productRelation: ProductRelation[] = [new ProductRelation()];
    isAuctionItem: number | string | null = "";
    auctionPeriod: string | null;
    productCreationDate: string | null;
    isExpired: string | null;
    auctionStatus: number | string | null = "";
    jitsiToken: string = "";
    highestBidPrice: string = "";
    commission: string = "";

    init(
        id: string,
        catId: string,
        subCatId: string,
        itemCurrencyId: string,
        itemLocationId: string,
        itemLocationTownshipId: string,
        description: string,
        isWarrantyItem: string | number,
        preferredPayment: string,
        price: string,
        percent: string,
        phone: string,
        isSoldOut: string,
        title: string,
        lat: string,
        lng: string,
        status: string,
        addedDate: string,
        addedUserId: string,
        isDiscount: string,
        touchCount: string,
        favouriteCount: string,
        isPaid: string,
        dynamicLink: string,
        addedDateStr: string,
        paidStatus: string,
        photoCount: string,
        defaultPhoto: DefaultPhoto,
        video: DefaultPhoto,
        videoThumbnail: DefaultPhoto,
        category: Category,
        subCategory: SubCategory,
        itemCurrency: ItemCurrency,
        itemLocation: ItemLocation,
        itemLocationTownship: ItemLocationTownship,
        user: User,
        vendor: Vendor,
        isFavourited: string,
        isOwner: string,
        originalPrice: string,
        adType: string,
        productRelation: ProductRelation[],
        isAuctionItem: number | string | null,
        auctionPeriod: string | null,
        productCreationDate: string | null,
        isExpired: string | null,
        auctionStatus: number | string | null,
        jitsiToken: string,
        highestBidPrice: string,
        commission: string
    ) {
        this.id = id;
        this.catId = catId;
        this.subCatId = subCatId;
        this.itemCurrencyId = itemCurrencyId;
        this.itemLocationId = itemLocationId;
        this.itemLocationTownshipId = itemLocationTownshipId;
        this.description = description;
        this.isWarrantyItem = isWarrantyItem;
        this.preferredPayment = preferredPayment;
        this.price = price;
        this.percent = percent;
        this.phone = phone;
        this.isSoldOut = isSoldOut;
        this.title = title;
        this.lat = lat;
        this.lng = lng;
        this.status = status;
        this.addedDate = addedDate;
        this.addedUserId = addedUserId;
        this.isDiscount = isDiscount;
        this.touchCount = touchCount;
        this.favouriteCount = favouriteCount;
        this.isPaid = isPaid;
        this.dynamicLink = dynamicLink;
        this.addedDateStr = addedDateStr;
        this.paidStatus = paidStatus;
        this.photoCount = photoCount;
        this.defaultPhoto = defaultPhoto;
        this.video = video;
        this.videoThumbnail = videoThumbnail;
        this.category = category;
        this.subCategory = subCategory;
        this.itemCurrency = itemCurrency;
        this.itemLocation = itemLocation;
        this.itemLocationTownship = itemLocationTownship;
        this.user = user;
        this.vendor = vendor;
        this.isFavourited = isFavourited;
        this.isOwner = isOwner;
        this.originalPrice = originalPrice;
        this.adType = adType;
        this.productRelation = productRelation;
        this.isAuctionItem = isAuctionItem;
        this.auctionPeriod = auctionPeriod;
        this.productCreationDate = productCreationDate;
        this.isExpired = isExpired;
        this.auctionStatus = auctionStatus;
        this.jitsiToken = jitsiToken;
        this.highestBidPrice = highestBidPrice;
        this.commission = commission;

        return this;
    }

    getPrimaryKey(): string {
        return this.id;
    }

    toMap(object: AuctionItem): any {
        const map = {};

        map["id"] = object.id;
        map["category_id"] = object.catId;
        map["subcategory_id"] = object.subCatId;
        map["currency_id"] = object.itemCurrencyId;
        map["location_city_id"] = object.itemLocationId;
        map["location_township_id"] = object.itemLocationTownshipId;
        map["description"] = object.description;
        map["is_warranty_item"] = object.isWarrantyItem;
        map["preferred_payment"] = object.preferredPayment;
        map["price"] = object.price;
        map["percent"] = object.percent;
        map["phone"] = object.phone;
        map["is_sold_out"] = object.isSoldOut;
        map["title"] = object.title;
        map["lat"] = object.lat;
        map["lng"] = object.lng;
        map["status"] = object.status;
        map["added_date"] = object.addedDate;
        map["added_user_id"] = object.addedUserId;
        map["is_discount"] = object.isDiscount;
        map["item_touch_count"] = object.touchCount;
        map["favourite_count"] = object.favouriteCount;
        map["is_paid"] = object.isPaid;
        map["dynamic_link"] = object.dynamicLink;
        map["added_date_str"] = object.addedDateStr;
        map["paid_status"] = object.paidStatus;
        map["photo_count"] = object.photoCount;
        map["default_photo"] = new DefaultPhoto().toMap(object.defaultPhoto);
        map["default_video"] = new DefaultPhoto().toMap(object.video);
        map["default_video_icon"] = new DefaultPhoto().toMap(
            object.videoThumbnail
        );
        map["category"] = new Category().toMap(object.category);
        map["sub_category"] = new SubCategory().toMap(object.subCategory);
        map["item_currency"] = new ItemCurrency().toMap(object.itemCurrency);
        map["item_location"] = new ItemLocation().toMap(object.itemLocation);
        map["item_location_township"] = new ItemLocationTownship().toMap(
            object.itemLocationTownship
        );
        map["user"] = new User().toMap(object.user);
        map["vendor"] = new Vendor().toMap(object.vendor);
        map["is_favourited"] = object.isFavourited;
        map["is_owner"] = object.isOwner;
        map["original_price"] = object.originalPrice;
        map["ad_type"] = object.adType;
        map["productRelation"] = new ProductRelation().toMapList(
            object.productRelation
        );
        map["is_auction_item"] = object.isAuctionItem;
        map["auction_period"] = object.auctionPeriod;
        map["product_creation_date"] = object.productCreationDate;
        map["is_expired"] = object.isExpired;
        map["auction_status"] = object.auctionStatus;
        map["jitsi_token"] = object.jitsiToken;
        map["highest_bid_price"] = object.highestBidPrice;
        map["commission"] = object.commission;

        return map;
    }

    toMapList(objectList: AuctionItem[]): any[] {
        const mapList: any[] = [];
        // console.log(" to map list -------- Auction Item ", objectList[0], objectList[1]);
        for (let i = 0; i < objectList.length; i++) {
            if (objectList[i] != null && objectList[i].isAuctionItem == 1) {
                mapList.push(this.toMap(objectList[i]));
            }
        }

        return mapList;
    }

    fromMap(obj: any) {
        return new AuctionItem().init(
            obj.id,
            obj.category_id,
            obj.subcategory_id,
            obj.currency_id,
            obj.location_city_id,
            obj.location_township_id,
            obj.description,
            obj.is_warranty_item,
            obj.preferred_payment,
            obj.price,
            obj.percent,
            obj.phone,
            obj.is_sold_out,
            obj.title,
            obj.lat,
            obj.lng,
            obj.status,
            obj.added_date,
            obj.added_user_id,
            obj.is_discount,
            obj.item_touch_count,
            obj.favourite_count,
            obj.is_paid,
            obj.dynamic_link,
            obj.added_date_str,
            obj.paid_status,
            obj.photo_count,
            new DefaultPhoto().fromMap(obj.default_photo),
            new DefaultPhoto().fromMap(obj.default_video),
            new DefaultPhoto().fromMap(obj.default_video_icon),
            new Category().fromMap(obj.category),
            new SubCategory().fromMap(obj.sub_category),
            new ItemCurrency().fromMap(obj.item_currency),
            new ItemLocation().fromMap(obj.item_location),
            new ItemLocationTownship().fromMap(obj.item_location_township),
            new User().fromMap(obj.user),
            new Vendor().fromMap(obj.vendor),
            obj.is_favourited,
            obj.is_owner,
            obj.original_price,
            obj.ad_type,
            new ProductRelation().fromMapList(obj.productRelation),
            obj.is_auction_item,
            obj.auction_period,
            obj.product_creation_date,
            obj.is_expired,
            obj.auction_status,
            obj.jitsi_token,
            obj.highest_bid_price,
            obj.commission
        );
    }

    fromMapList(objList: any[]): AuctionItem[] {
        const auctionItemList: AuctionItem[] = [];
        for (const obj of objList as Array<AuctionItem>) {
            if (obj != null) {
                auctionItemList.push(this.fromMap(obj));
            }
        }

        return auctionItemList;
    }
}
