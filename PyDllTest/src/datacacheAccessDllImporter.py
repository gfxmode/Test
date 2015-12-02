#! /usr/bin/env python2
# -*- coding: utf-8 -*-

__version__ = '1.0.0'
__author__ = 'gfxmode(gfxmode@live.com)'

'''
python2 interface of datacacheaccess.dll
'''

from datacacheAccessDefine import *;

class CDataCacheAccessImporter:
    def __init__(self, dllDir):
        self.strDllName = 'datacacheaccess.dll';
        self.hDll = windll.LoadLibrary(dllDir + "\\" + self.strDllName);
        
        self.hDll.DCA_InitializeA.argtypes = [c_void_p, c_char_p, c_ulong, c_ulong, \
                                               c_ulong, c_ulong, c_long];
        self.hDll.DCA_Finalize.argtypes = [c_void_p];
        self.hDll.DCA_GetNewestID.argtypes = [c_void_p];
        self.hDll.DCA_GetOldestID.argtypes = [c_void_p];
        self.hDll.DCA_Read_by_uid.argtypes = [c_void_p, c_void_p, c_ulonglong, c_ulong, \
                                              c_void_p, c_void_p, c_void_p, c_ulong]
    
    # DCA接口初始化
    def DCA_Initialize(self, pObj, workingDir, stationID, dataType, idxFileLen, \
                      datFileLen, accessType):
        return self.hDll.DCA_InitializeA(byref(pObj), workingDir, stationID, dataType, \
                             idxFileLen, datFileLen, accessType);
                             
    # DCA接口调用结束                         
    def DCA_Finalize(self, pObj):
        return self.hDll.DCA_Finalize(pObj); 
    
    # 获取最新的ID
    def DCA_GetNewestID(self, pObj):
        return self.hDll.DCA_GetNewestID(pObj);
    
    # 取取最旧的ID
    def DCA_GetOldestID(self, pObj):
        return self.hDll.DCA_GetOldestID(pObj);
    
    # 根所uid读DataCache数据
    def DCA_Read_by_uid(self, pObj, pDats, stalogid, numNeedRead, numReaded, pIdx, \
                        pAddonbuf, addonbuflen):
        self.hDll.DCA_Read_by_uid(pObj, pDats, stalogid, numNeedRead, byref(numReaded), \
                                         pIdx, pAddonbuf, addonbuflen)


'''
Test Case
'''      
 # 定时记录读取接口调用测试 
def readDatalogTest(dllObj):
    pDatalogObj = c_void_p(None);

    dllObj.DCA_Initialize(pDatalogObj, "D:\CET_P35\Common", 1, DATACACHE_TYPE_DATALOG, \
             DATACACHE_DATALOG_IDXFILELEN, DATACACHE_DATALOG_DATFILELEN, GENERIC_READ);
    ullNewestID = dllObj.DCA_GetNewestID(pDatalogObj);
    ullOldestID = dllObj.DCA_GetOldestID(pDatalogObj);
    
    # 从DataCache中取定时记录
    numReaded = c_ulong(0);
    numNeedRead = c_ulong(100);
    TArrDatalog = tagDATALOG * MAX_RWLOGCNT;
    arrDatalog = TArrDatalog();
    pArrDatalog = POINTER(tagDATALOG)();
    pArrDatalog.contents = arrDatalog; 
    TArrDatalogIdx = tagDTSNINDEX * MAX_RWLOGCNT;
    arrDatalogIdx = TArrDatalogIdx();
    pArrDatalogIdx = POINTER(tagDTSNINDEX)();
    pArrDatalogIdx.contents = arrDatalogIdx;
    
    datalog_addonbuf = c_void_p(None);
    datalog_addonbuflen = c_ulong(0);
    dllObj.DCA_Read_by_uid(pDatalogObj, pArrDatalog, ullOldestID, numNeedRead, \
           numReaded, pArrDatalogIdx, datalog_addonbuf, datalog_addonbuflen);
                           
    # 显示查询的结果
    for i in range(numReaded.value):
        print pArrDatalog[i].systm.wYear;
    
    dllObj.DCA_Finalize(pDatalogObj);

# 事件记录读取接口调用测试
def readEventlogTest(dllObj):
    pEventlogObj = c_void_p(None);
    dllObj.DCA_Initialize(pEventlogObj, "D:\CET_P35\Common", 1, DATACACHE_TYPE_EVENTLOG, \
            DATACACHE_EVENTLOG_IDXFILELEN, DATACACHE_EVENTLOG_DATFILELEN, GENERIC_READ);
    ullNewestID = dllObj.DCA_GetNewestID(pEventlogObj);
    ullOldestID = dllObj.DCA_GetOldestID(pEventlogObj);

    # 从DataCache中获取事件记录
    numReaded = c_ulong(0);
    numNeedRead = c_ulong(100);
    TArrEventlog = tagEVENTLOG * MAX_RWLOGCNT;
    arrEventlog = TArrEventlog();
    pArrEventlog = POINTER(tagEVENTLOG)();
    pArrEventlog.contents = arrEventlog;
    TArrEventlogIdx = tagDTSNINDEX * MAX_RWLOGCNT;
    arrEventlogIdx = TArrEventlogIdx();
    pArrEventlogIdx = POINTER(tagDTSNINDEX)();
    pArrEventlogIdx.contents = arrEventlogIdx;

    eventlog_addonbuf = c_void_p(None);
    eventlog_addonbuflen = c_ulong(0);
    dllObj.DCA_Read_by_uid(pEventlogObj, pArrEventlog, ullOldestID, numNeedRead, \
            numReaded, pArrEventlogIdx, eventlog_addonbuf, eventlog_addonbuflen);

    print sizeof(tagEVENTLOG);
    # 显示查询的结果
#     for i in range(numReaded.value):
#         print str(pArrEventlog[i].time) + "." + str(pArrEventlog[i].msec);

    dllObj.DCA_Finalize(pEventlogObj);

# 波形记录读取接口调用测试   
def readWformTest(dllObj):
    pWformlogObj = c_void_p(None);
    dllObj.DCA_Initialize(pWformlogObj, "D:\CET_P35\Common", 1, DATACACHE_TYPE_WFORMLOG, \
            DATACACHE_WFORMLOG_IDXFILELEN, DATACACHE_WFORMLOG_DATFILELEN, GENERIC_READ);
    ullNewestID = dllObj.DCA_GetNewestID(pWformlogObj);
    ullOldestID = dllObj.DCA_GetOldestID(pWformlogObj);
    
    # 从DataCache中获取波形记录，一次只取一条波形
    numReaded = c_ulong(0);
    numNeedRead = c_ulong(1);
    pCommtradeBuff = create_string_buffer(MAX_COMTRADE_FILELEN);
    TWformlog = tagWFORMLOG * 1;
    aWformlog = TWformlog();
    pWformlog = POINTER(tagWFORMLOG)();
    pWformlog.contents = aWformlog;
    TArrWformlogIdx = tagDTSNINDEX * MAX_RWLOGCNT;
    arrWformlogIdx = TArrWformlogIdx();
    pArrWformlogIdx = POINTER(tagDTSNINDEX)();
    pArrWformlogIdx.contents = arrWformlogIdx;
    
    
    dllObj.DCA_Read_by_uid(pWformlogObj, byref(aWformlog), ullOldestID, 1, \
            numReaded, pArrWformlogIdx, pCommtradeBuff, sizeof(c_ubyte) * MAX_COMTRADE_FILELEN);
    print numReaded;

if __name__ == "__main__":
    dllObj = CDataCacheAccessImporter("D:\CET_P35\Common");
    readDatalogTest(dllObj);
    readEventlogTest(dllObj);
    readWformTest(dllObj);
