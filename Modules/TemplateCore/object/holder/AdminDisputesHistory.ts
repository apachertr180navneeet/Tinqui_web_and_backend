// import { PsObject } from "../core/PsObject";

// export default class AdminDisputesHistory extends PsObject<AdminDisputesHistory> {
//     id: string = "";
//     buyerId: string = "";
//     sellerId: string = "";
//     bidPrice: string = "";
//     productPrice: string = "";
//     productId: string = "";
//     productTitle: string = "";
//     bidStatus: string = "";
//     bidCommission: string = "";
//     amountPaid: string = "";
//     disputedBid: string = "";
//     disputeType: string = "";
//     disputeReason: string = "";
//     disputeStatus: string = "";
//     disputeStatusNotes: string = "";
//     disputeImages: string = "";
//     updatedateTime: string = "";
//     buyerName: string = "";
//     sellerName: string = "";
//     createdAt: string = "";
//     updatedAt: string = "";

//     init(
//         id: string,
//         buyerId: string,
//         sellerId: string,
//         bidPrice: string,
//         productPrice: string,
//         productId: string,
//         productTitle: string,
//         bidStatus: string,
//         bidCommission: string,
//         amountPaid: string,
//         disputedBid: string,
//         disputeType: string,
//         disputeReason: string,
//         disputeStatus: string,
//         disputeStatusNotes: string,
//         disputeImages: string,
//         updatedateTime: string,
//         buyerName: string,
//         sellerName: string,
//         createdAt: string,
//         updatedAt: string
//     ) {
//         this.id = id;
//         this.buyerId = buyerId;
//         this.sellerId = sellerId;
//         this.bidPrice = bidPrice;
//         this.productPrice = productPrice;
//         this.productId = productId;
//         this.productTitle = productTitle;
//         this.bidStatus = bidStatus;
//         this.bidCommission = bidCommission;
//         this.amountPaid = amountPaid;
//         this.disputedBid = disputedBid;
//         this.disputeType = disputeType;
//         this.disputeReason = disputeReaso;
//         this.disputeStatus = disputeStatus;
//         this.disputeStatusNotes = disputeStatusNotes;
//         this.disputeImages = disputeImages;
//         this.updatedateTime = updatedateTime;
//         this.buyerName = buyerName;
//         this.sellerName = sellerName;
//         this.createdAt = createdAt;
//         this.updatedAt = updatedAt;

//         return this;
//     }

//     getPrimaryKey(): string {
//         return this.id;
//     }

//     fromMap(obj: any) {
//         return new AdminDisputesHistory().init(
//             obj.id,
//             obj.buyer_id,
//             obj.seller_id,
//             obj.bid_price,
//             obj.product_price,
//             obj.product_id,
//             obj.product_title,
//             obj.bid_status,
//             obj.bid_commission,
//             obj.amount_paid,
//             obj.disputedBid,
//             obj.disputeType,
//             obj.disputeReason,
//             obj.disputeStatus,
//             obj.disputeStatusNotes,
//             obj.disputeImages,
//             obj.updatedateTime,
//             obj.buyerName,
//             obj.sellerName,
//             obj.created_at,
//             obj.updated_at
//         );
//     }

//     fromMapList(objList: any[]): AdminDisputesHistory[] {
//         const AdminDisputesHistoryList: AdminDisputesHistory[] = [];
//         for (let index = 0; index < objList.length; index++) {
//             const obj = objList[index];
//             if (obj != null) {
//                 AdminDisputesHistoryList.push(this.fromMap(obj));
//             }
//         }

//         return AdminDisputesHistoryList;
//     }

//     toMap(object: AdminDisputesHistory): any {
//         const map = {};
//         map["id"] = object.id;
//         map["buyer_id"] = object.buyerId;
//         map["seller_id"] = object.sellerId;
//         map["bid_price"] = object.bidPrice;
//         map["product_price"] = object.productPrice;
//         map["product_id"] = object.productId;
//         map["product_title"] = object.productTitle;
//         map["bid_status"] = object.bidStatus;
//         map["bid_status"] = object.bidStatus;
//         map["bid_commission"] = object.bidCommission;
//         map["disputed_bid"] = object.disputedBid;
//         map["dispute_type"] = object.disputeType;
//         map["dispute_reason"] = object.disputeReason;
//         map["dispute_status"] = object.disputeStatus;
//         map["dispute_status_notes"] = object.disputeStatusNotes;
//         map["dispute_images"] = object.disputeImages;
//         map["update_date_time"] = object.updatedateTime;
//         map["buyer_name"] = object.buyerName;
//         map["seller_name"] = object.sellerName;
//         map["created_at"] = object.createdAt;
//         map["updated_at"] = object.updatedAt;

//         return map;
//     }

//     toMapList(objectList: AdminDisputesHistory[]): any[] {
//         const mapList: any[] = [];
//         for (let i = 0; i < objectList.length; i++) {
//             if (objectList[i] != null) {
//                 mapList.push(this.toMap(objectList[i]));
//             }
//         }

//         return mapList;
//     }
// }
