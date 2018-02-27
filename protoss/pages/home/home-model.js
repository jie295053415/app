class Home {
  constructor () {

  }

  getBannerData (id, callBack) {
    wx.request({
      url: 'http://z.cn/api/v1/banner' + id,
      method : 'GET',
      success : function (res) {
        // return res
        callBack(res);
      }
    })
  }

}