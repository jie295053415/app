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
    var id, data;
    id = 1;
    data = home.getBannerData(id);
  }
})