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
    var id = null;
    wx.navigateTo({
      url: '../product/product?id=' + id,
    })
  }
})