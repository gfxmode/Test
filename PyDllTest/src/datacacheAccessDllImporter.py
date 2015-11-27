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
    def DCA_Read_by_uid(self, pObj, pDats, stalogid, needread, readedRef, pIdx, \
                        pAddonbuf, addonbuflen):
        self.hDll.DCA_Read_by_uid(pObj, pDats, stalogid, needread, byref(readedRef), \
                                         pIdx, pAddonbuf, addonbuflen)

if __name__ == "__main__":
    dcaObj = CDataCacheAccessImporter("D:\CET_P35\Common");
    # 定时记录接口调用测试
    pDatalogObj = c_void_p(None);

    dcaObj.DCA_Initialize(pDatalogObj, "D:\CET_P35\Common", 1, DATACACHE_TYPE_DATALOG, \
                         DATACACHE_DATALOG_IDXFILELEN, DATACACHE_DATALOG_DATFILELEN, GENERIC_READ);
    ullNewestID = dcaObj.DCA_GetNewestID(pDatalogObj);
    ullOldestID = dcaObj.DCA_GetOldestID(pDatalogObj);
    
    # 从DataCache中取定时记录
    NeedRead = 100;
    datalog_Readed = c_ulong(0);
    datalog_NeedRead = c_ulong(10);
    TArrDatalog = tagDATALOG * MAX_RWLOGCNT;
    arrDatalog = TArrDatalog();
    pArrDatalog = POINTER(tagDATALOG)();
    pArrDatalog.contents = arrDatalog; 
    TArrDatalogIdx = tagDTSNINDEX * MAX_RWLOGCNT;
    arrDatalogIdx = TArrDatalogIdx();
    pArrDatalogIdx = POINTER(tagDTSNINDEX)();
    pArrDatalogIdx.contents = arrDatalogIdx;
    
    print sizeof(tagDATALOG)
    
    datalog_addonbuf = c_void_p(None);
    datalog_addonbuflen = c_ulong(0);
    dcaObj.DCA_Read_by_uid(pDatalogObj, pArrDatalog, ullOldestID, datalog_NeedRead, \
                           datalog_Readed, pArrDatalogIdx, datalog_addonbuf, datalog_addonbuflen);
    print datalog_Readed.value;
    print ullNewestID, ullOldestID;
    
    dcaObj.DCA_Finalize(pDatalogObj);