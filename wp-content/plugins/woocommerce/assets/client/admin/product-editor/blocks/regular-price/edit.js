"use strict";var __importDefault=this&&this.__importDefault||function(e){return e&&e.__esModule?e:{default:e}};Object.defineProperty(exports,"__esModule",{value:!0}),exports.Edit=void 0;const classnames_1=__importDefault(require("classnames")),components_1=require("@woocommerce/components"),currency_1=require("@woocommerce/currency"),navigation_1=require("@woocommerce/navigation"),tracks_1=require("@woocommerce/tracks"),block_editor_1=require("@wordpress/block-editor"),compose_1=require("@wordpress/compose"),core_data_1=require("@wordpress/core-data"),element_1=require("@wordpress/element"),i18n_1=require("@wordpress/i18n"),components_2=require("@wordpress/components"),use_currency_input_props_1=require("../../hooks/use-currency-input-props"),utils_1=require("../../utils"),validation_context_1=require("../../contexts/validation-context");function Edit({attributes:e,clientId:r}){const t=(0,block_editor_1.useBlockProps)(),{label:o,help:n}=e,[c,i]=(0,core_data_1.useEntityProp)("postType","product","regular_price"),[s]=(0,core_data_1.useEntityProp)("postType","product","sale_price"),a=(0,element_1.useContext)(currency_1.CurrencyContext),{getCurrencyConfig:u,formatAmount:_}=a,l=u(),p=(0,use_currency_input_props_1.useCurrencyInputProps)({value:c,setValue:i}),m=n?(0,element_1.createInterpolateElement)(n,{PricingTab:(0,element_1.createElement)(components_1.Link,{href:(0,navigation_1.getNewPath)({tab:"pricing"}),onClick:()=>{(0,tracks_1.recordEvent)("product_pricing_help_click")}})}):null,d=(0,compose_1.useInstanceId)(components_2.BaseControl,"wp-block-woocommerce-product-regular-price-field"),{ref:f,error:g,validate:y}=(0,validation_context_1.useValidation)(`regular_price-${r}`,(async function(){const e=Number.parseFloat(c);if(e){if(e<0)return(0,i18n_1.__)("List price must be greater than or equals to zero.","woocommerce");if(s&&e<=Number.parseFloat(s))return(0,i18n_1.__)("List price must be greater than the sale price.","woocommerce")}}),[c,s]);return(0,element_1.createElement)("div",{...t},(0,element_1.createElement)(components_2.BaseControl,{id:d,help:g||m,className:(0,classnames_1.default)({"has-error":g})},(0,element_1.createElement)(components_2.__experimentalInputControl,{...p,id:d,name:"regular_price",ref:f,label:o,value:(0,utils_1.formatCurrencyDisplayValue)(String(c),l,_),onChange:i,onBlur:y})))}exports.Edit=Edit;