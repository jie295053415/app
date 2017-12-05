
class Home{
  getDannerData(){
    wx.request({
      url : 'heep://z.cn/api/v1/banner/2',
      method : 'GET',
      success : function(res){
        return res
      }
    })
  }
}