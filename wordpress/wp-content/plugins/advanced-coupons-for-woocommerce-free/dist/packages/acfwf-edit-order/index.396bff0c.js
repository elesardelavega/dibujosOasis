function O(){import.meta.url,import("_").catch(()=>1);async function*t(){}}function m(){jQuery("#woocommerce-order-items").block({message:null,overlayCSS:{background:"#fff",opacity:.6}})}function i(){jQuery("#woocommerce-order-items").unblock()}const e=jQuery;function y(){e("#woocommerce-order-items").on("click","button.refund-items",w),e("#woocommerce-order-items").on("change keyup",".wc-order-refund-items #refund_amount",b),e("body").on("click","button#acfw-refund-as-store-credits",x),e("body").on("order-totals-recalculate-complete",f),f()}function w(){e("#acfw-refund-as-store-credits").length||(e("#post-body .refund-actions").prepend('<button type="button" id="acfw-refund-as-store-credits" class="button button-primary">'.concat(acfwEditOrder.button_text,"</button>")),e("#post-body button.refund-items").on("click",w))}function b(){const t=e(this).val(),r=accounting.unformat(t,woocommerce_admin.mon_decimal_point);e("button#acfw-refund-as-store-credits .amount").text(accounting.formatMoney(r,{symbol:woocommerce_admin_meta_boxes.currency_format_symbol,decimal:woocommerce_admin_meta_boxes.currency_format_decimal_sep,thousand:woocommerce_admin_meta_boxes.currency_format_thousand_sep,precision:woocommerce_admin_meta_boxes.currency_format_num_decimals,format:woocommerce_admin_meta_boxes.currency_format}))}function x(){m(),window.confirm(woocommerce_admin_meta_boxes.i18n_do_refund)||i();const t=e("input#refund_amount").val(),r=e("input#refund_reason").val(),a=e("input#refunded_amount").val(),u={},l={},d={};e(".refund input.refund_order_item_qty").each(function(c,o){e(o).closest("tr").data("order_item_id")&&e(o).val()&&(u[e(o).closest("tr").data("order_item_id")]=e(o).val())}),e(".refund input.refund_line_total").each(function(c,o){e(o).closest("tr").data("order_item_id")&&(l[e(o).closest("tr").data("order_item_id")]=accounting.unformat(e(o).val(),woocommerce_admin.mon_decimal_point))}),e(".refund input.refund_line_tax").each(function(c,o){if(e(o).closest("tr").data("order_item_id")){var p=e(o).data("tax_id");d[e(o).closest("tr").data("order_item_id")]||(d[e(o).closest("tr").data("order_item_id")]={}),d[e(o).closest("tr").data("order_item_id")][p]=accounting.unformat(e(o).val(),woocommerce_admin.mon_decimal_point)}});const n={action:"woocommerce_refund_line_items",order_id:woocommerce_admin_meta_boxes.post_id,refund_amount:t,refunded_amount:a,refund_reason:r,line_item_qtys:JSON.stringify(u,null,""),line_item_totals:JSON.stringify(l,null,""),line_item_tax_totals:JSON.stringify(d,null,""),api_refund:e(this).is(".do-api-refund"),restock_refunded_items:e("#restock_refunded_items:checked").length?"true":"false",security:woocommerce_admin_meta_boxes.order_item_nonce,acfw_store_credits:!0};e.ajax({url:woocommerce_admin_meta_boxes.ajax_url,data:n,type:"POST",success:function(c){c.success===!0?window.location.reload():(window.alert(c.data.error),e("#woocommerce-order-items").trigger("wc_order_items_reload"),i())},complete:function(){wcTracks.recordEvent("order_edit_refunded",{order_id:n.order_id,status:e("#order_status").val(),api_refund:n.api_refund,has_reason:!!n.refund_reason,restock:n.restock_refunded_items==="true"})}})}function f(){e(".wc-order-totals-items .wc-order-totals tr.acfw-payment-row").length&&(e(".wc-order-totals-items .wc-order-totals tr.acfw-payment-row").appendTo(".wc-order-totals-items .wc-order-totals:first-child tbody"),e(".wc-order-totals-items .wc-order-totals tr.acfw-payment-row").removeClass("acfw-payment-row"),e(".wc-order-totals-items table.wc-order-totals").length>2&&e(e(".wc-order-totals-items table.wc-order-totals")[1]).remove())}const s=jQuery;function v(){s("body").on("click","button.acfw-apply-store-credits",g),h()}function g(){s(this);const t=window.prompt(acfwEditOrder.apply_store_credits_prompt,acfwEditOrder.order_store_credits_amount);t!==null&&(m(),s.ajax({url:woocommerce_admin_meta_boxes.ajax_url,data:{action:"acfwf_apply_store_credits_to_order",order_id:woocommerce_admin_meta_boxes.post_id,amount:t,security:woocommerce_admin_meta_boxes.order_item_nonce},type:"POST",success:function(r){r.success===!0?window.location.reload():window.alert(r.data.error),i()}}))}function h(){s("ul.wc_coupon_list li span span:contains('".concat(acfwEditOrder.store_credit_coupon_code,"')")).closest(".code").removeClass("editable").find("a.remove-coupon").remove()}const _=jQuery;function k(){_("body").on("click","button.acfw-refund-store-credits",S)}function S(){const t=_(this),r=window.prompt(t.data("prompt"));r!==null&&(m(),_.ajax({url:woocommerce_admin_meta_boxes.ajax_url,data:{action:"acfwf_refund_store_credits_discount_from_order",order_id:woocommerce_admin_meta_boxes.post_id,amount:r,security:woocommerce_admin_meta_boxes.order_item_nonce},type:"POST",success:function(a){a.success===!0?window.location.reload():window.alert(a.data.error),i()}}))}jQuery(document).ready(function(t){y(),v(),k()});export{O as __vite_legacy_guard};