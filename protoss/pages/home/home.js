// pages/home/home.js
import {Home} from 'home-model';

var home = new Home();

Page({

  /**
   * 页面的初始数据
   */
  data: {
  
  },

  onLoad:function(){
    this._loadData();
  },

  _loadData:function(){
    var that = this;
    var id = 1;
    home.getBannerData(id, (res)=>{
       // data bind
      that.setData({
        'bannerArr' : res
      });
    });

    home.getThemeData((res)=>{
      that.setData({
        'themeArr' : res
      });
    });

    home.getProductsData((data)=>{
      that.setData({
        productsArr : data
      });
    });
  }, 

  onProductsItemTap : function (event) {
    var id = home.getDataSet(event, 'id');
    wx.navigateTo({
      url: '../product/product?id=' + id,
    })
  },
onThemesItemTap : function (event) {
  var id = home.getdataSet(event, 'id');
  var id = home.getdataSet(event, 'name');
  wx.navigateTo({
    url: '../theme/theme?id=' + id + '&name=' + name,
  })
} 

})