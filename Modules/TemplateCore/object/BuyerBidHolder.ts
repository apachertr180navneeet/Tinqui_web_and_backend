import { PsObject } from "@templateCore/object/core/PsObject";
import DefaultPhoto from "./DefaultPhoto";
import Category from "./Category";

export default class BuyerBidResponse extends PsObject<BuyerBidResponse> {
    id: string = "";
    title: string = "";
    categoryId: string = "";
    subCategoryId: string | null = "";
    itemCurrencyId: string = "";
    cityId: string = "";
    townshipId: string | null = "";
    shopId: string | null = "";
    price: string = "";
    originalPrice: string = "";
    description: string = "";
    searchTag: string | null = null;
    dynamicLink: string = "";
    lat: string = "";
    lng: string = "";
    status: string = "";
    isPaid: string = "";
    isSoldOut: string = "";
    ordering: string | null = "";
    isAvailable: string = "";
    isDiscount: string = "";
    touchCount: string = "";
    favouriteCount: string = "";
    overallRating: string = "";
    vendorId: string | null = "";
    addedDate: string = "";
    addedUserId: string = "";
    updatedDate: string = "";
    updatedUserId: string | null = "";
    updatedFlag: string | null = "";
    deletedAt: string | null = "";
    percent: string = "";
    phone: string | null = "";
    isAuctionItem: string = "";
    auctionPeriod: string = "";
    productCreationDate: string = "";
    isExpired: string = "";
    auctionStatus: string = "";
    auctionIds: string | null = "";
    auctionPrice: string | null = "";
    isWarrantyItem: string = "";
    preferredPayment: string = "";
    totalBids: string = "";
    highestBid: string = "";
    commission: string = "";
    category: Category = new Category();
    cover: DefaultPhoto = new DefaultPhoto();
    video: DefaultPhoto = new DefaultPhoto();
    icon: DefaultPhoto = new DefaultPhoto();

    init(
        id: string,
        title: string,
        categoryId: string,
        subCategoryId: string | null,
        itemCurrencyId: string,
        cityId: string,
        townshipId: string,
        shopId: string,
        price: string,
        originalPrice: string,
        description: string,
        searchTag: null,
        dynamicLink: string,
        lat: string,
        lng: string,
        status: string,
        isPaid: string,
        isSoldOut: string,
        ordering: string,
        isAvailable: string,
        isDiscount: string,
        touchCount: string,
        favouriteCount: string,
        overallRating: string,
        vendorId: string,
        addedDate: string,
        addedUserId: string,
        updatedDate: string,
        updatedUserId: string,
        updatedFlag: string,
        deletedAt: string,
        percent: string,
        phone: string,
        isAuctionItem: string,
        auctionPeriod: string,
        productCreationDate: string,
        isExpired: string,
        auctionStatus: string,
        auctionIds: string,
        auctionPrice: string,
        isWarrantyItem: string,
        preferredPayment: string,
        totalBids: string,
        highestBid: string,
        commission: string,
        category: Category,
        cover: DefaultPhoto,
        video: DefaultPhoto,
        icon: DefaultPhoto
    ) {
        this.id = id;
        this.title = title;
        this.categoryId = categoryId;
        this.subCategoryId = subCategoryId;
        this.itemCurrencyId = itemCurrencyId;
        this.cityId = cityId;
        this.townshipId = townshipId;
        this.shopId = shopId;
        this.price = price;
        this.originalPrice = originalPrice;
        this.description = description;
        this.searchTag = searchTag;
        this.dynamicLink = dynamicLink;
        this.lat = lat;
        this.lng = lng;
        this.status = status;
        this.isPaid = isPaid;
        this.isSoldOut = isSoldOut;
        this.ordering = ordering;
        this.isAvailable = isAvailable;
        this.isDiscount = isDiscount;
        this.touchCount = touchCount;
        this.favouriteCount = favouriteCount;
        this.overallRating = overallRating;
        this.vendorId = vendorId;
        this.addedDate = addedDate;
        this.addedUserId = addedUserId;
        this.updatedDate = updatedDate;
        this.updatedUserId = updatedUserId;
        this.updatedFlag = updatedFlag;
        this.deletedAt = deletedAt;
        this.percent = percent;
        this.phone = phone;
        this.isAuctionItem = isAuctionItem;
        this.auctionPeriod = auctionPeriod;
        this.productCreationDate = productCreationDate;
        this.isExpired = isExpired;
        this.auctionStatus = auctionStatus;
        this.auctionIds = auctionIds;
        this.auctionPrice = auctionPrice;
        this.isWarrantyItem = isWarrantyItem;
        this.preferredPayment = preferredPayment;
        this.totalBids = totalBids;
        this.highestBid = highestBid;
        this.commission = commission;
        this.category = category;
        this.cover = cover;
        this.video = video;
        this.icon = icon;

        return this;
    }

    toMap(object: BuyerBidResponse): any {
        const map = {};

        map["id"] = object.id;
        map["category_id"] = object.categoryId;
        map["subcategory_id"] = object.subCategoryId;
        map["currency_id"] = object.itemCurrencyId;
        map["location_city_id"] = object.cityId;
        map["location_township_id"] = object.townshipId;
        map["shop_id"] = object.shopId;
        map["price"] = object.price;
        map["original_price"] = object.originalPrice;
        map["description"] = object.description;
        map["search_tag"] = object.searchTag;
        map["dynamic_link"] = object.dynamicLink;
        map["lat"] = object.lat;
        map["lng"] = object.lng;
        map["status"] = object.status;
        map["is_paid"] = object.isPaid;
        map["is_sold_out"] = object.isSoldOut;
        map["ordering"] = object.ordering;
        map["is_available"] = object.isAvailable;
        map["is_discount"] = object.isDiscount;
        map["item_touch_count"] = object.touchCount;
        map["favourite_count"] = object.favouriteCount;
        map["overall_rating"] = object.overallRating;
        map["vendor_id"] = object.vendorId;
        map["added_date"] = object.addedDate;
        map["added_user_id"] = object.addedUserId;
        map["updated_date"] = object.updatedDate;
        map["updated_user_id"] = object.updatedUserId;
        map["updated_flag"] = object.updatedFlag;
        map["deleted_at"] = object.deletedAt;
        map["percent"] = object.percent;
        map["phone"] = object.phone;
        map["is_auction_item"] = object.isAuctionItem;
        map["auction_period"] = object.auctionPeriod;
        map["product_creation_date"] = object.productCreationDate;
        map["is_expired"] = object.isExpired;
        map["auction_status"] = object.auctionStatus;
        map["auction_ids"] = object.auctionIds;
        map["auction_price"] = object.auctionPrice;
        map["is_warranty_item"] = object.isWarrantyItem;
        map["preferred_payment"] = object.preferredPayment;
        map["total_bids_on_product"] = object.totalBids;
        map["highest_bid_price"] = object.highestBid;
        map["commission"] = object.commission;
        map["category"] = object.category;
        map["cover"] = object.cover;
        map["video"] = object.video;
        map["icon"] = object.icon;

        return map;
    }

    toMapList(objectList: BuyerBidResponse[]): any[] {
        const mapList: any[] = [];
        for (let i = 0; i < objectList.length; i++) {
            if (objectList[i] != null) {
                mapList.push(this.toMap(objectList[i]));
            }
        }

        return mapList;
    }

    fromMap(obj: any) {
        return new BuyerBidResponse().init(
            obj.id,
            obj.title,
            obj.category_id,
            obj.subcategory_id,
            obj.currency_id,
            obj.location_city_id,
            obj.location_township_id,
            obj.shop_id,
            obj.price,
            obj.original_price,
            obj.description,
            obj.search_tag,
            obj.dynamic_link,
            obj.lat,
            obj.lng,
            obj.status,
            obj.is_paid,
            obj.is_sold_out,
            obj.ordering,
            obj.is_available,
            obj.is_discount,
            obj.item_touch_count,
            obj.favourite_count,
            obj.overall_rating,
            obj.vendor_id,
            obj.added_date,
            obj.added_user_id,
            obj.updated_date,
            obj.updated_user_id,
            obj.updated_flag,
            obj.deleted_at,
            obj.percent,
            obj.phone,
            obj.is_auction_item,
            obj.auction_status,
            obj.auction_ids,
            obj.auction_price,
            obj.is_warranty_item,
            obj.preferred_payment,
            obj.auction_period,
            obj.product_creation_date,
            obj.is_expired,
            obj.total_bids_on_product,
            obj.highest_bid_price,
            obj.commission,
            obj.category,
            obj.cover,
            obj.video,
            obj.icon
        );
    }

    fromMapList(objList: any[]): BuyerBidResponse[] {
        const buyerBidResponseList: BuyerBidResponse[] = [];
        for (const obj of objList as Array<BuyerBidResponse>) {
            if (obj != null) {
                buyerBidResponseList.push(this.fromMap(obj));
            }
        }

        return buyerBidResponseList;
    }
}
