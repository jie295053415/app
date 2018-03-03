
import {Base} from '../../utils/base.js';

class Home extends Base {
  constructor () {
    super();
  }

  /** banner **/
  getBannerData (id, callback) {
    var params = {
      url : 'banner/' +id,
      sCallback : function (res) {
        callback && callback(res.items);
      }
    }
    this.request(params);
  }

  /** 首页主题 **/
  getthemeData(callback) {
    var param = {
      url: 'theme?ids=1,2,3',
      sCallback: function (data) {
        callback && callback(data);
      }
    }
    this.request(param);
  }

  /** 商品 **/
  getProductsData(callback) {
    var param = {
      url: 'product/recent',
      sCallback: function (data) {
        callback && callback(data);
      }
    }
    this.request(param);
  }
}

export {Home};