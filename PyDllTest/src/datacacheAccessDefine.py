#! /usr/bin/env python2
# -*- coding: utf-8 -*-

__version__ = '1.0.0'
__author__ = 'gfxmode(gfxmode@live.com)'
from ctypes import *;

'''
DataCacheAccess CONST VALUE DEFINE
'''
# 读 写权限定义
GENERIC_READ = 0x80000000;
GENERIC_WRITE = 0x40000000;
GENERIC_EXECUTE = 0x20000000;
GENERIC_ALL = 0x10000000;

# 各种类型数据的索引以及数据文件缺省大小
DATACACHE_DATALOG_IDXFILELEN = 32*1024*1024;
DATACACHE_DATALOG_DATFILELEN = 128*1024*1024;
DATACACHE_EVENTLOG_IDXFILELEN = 8*1024*1024;
DATACACHE_EVENTLOG_DATFILELEN = 64*1024*1024;
DATACACHE_WFORMLOG_IDXFILELEN = 8*1024*1024;
DATACACHE_WFORMLOG_DATFILELEN = 128*1024*1024;
DATACACHE_OTHER_IDXFILELEN = 8*1024*1024;
DATACACHE_OTHER_DATFILELEN = 64*1024*1024;
DATACACHE_DAYRPT_IDXFILELEN = 4*1024*1024;
DATACACHE_DAYRPT_DATFILELEN = 16*1024*1024;
DATACACHE_ENGRPT_IDXFILELEN = 4*1024*1024;
DATACACHE_ENGRPT_DATFILELEN = 16*1024*1024;

# 缓冲类型定义
DATACACHE_TYPE_DATALOG = 1;
DATACACHE_TYPE_EVENTLOG = 2;
DATACACHE_TYPE_WFORMLOG = 3;
DATACACHE_TYPE_DAYRPT = 4;
DATACACHE_TYPE_ENGRPT = 5;
DATACACHE_TYPE_OTHER = 6;

# 定义最大读取数
MAX_RWLOGCNT = 100;
# 故障录波文件最大字节数
MAX_COMTRADE_FILELEN = 2*1024*1024

'''
数据结构定义
'''
class tagSYSTEMTIME(Structure):
    _pack_ = 1;                     # 设置压缩存储
    _fields_ =[("wYear", c_uint16),
               ("wMonth", c_uint16),
               ("wDayOfWeek", c_uint16),
               ("wDay", c_uint16),
               ("wHour", c_uint16),
               ("wMinute", c_uint16),
               ("wSecond", c_uint16),
               ("wMilliseconds", c_uint16)]; 
# 数据序号，索引块
class tagDTSNINDEX(Structure):
    _pack_ = 1;                     # 设置压缩存储
    _fields_ = [("logtype", c_ushort),
                ("reserved1", c_ushort),
                ("datfileid", c_ulong),
                ("datfilepos", c_ulong),
                ("logidhi", c_ulong),
                ("logidlo", c_ulong),
                ("loglen", c_ulong),
                ("logcrc", c_ulong),
                ("reserved2", c_ushort),
                ("sumcrc", c_ushort)];  
# 定时记录结构体定义    
class tagDATALOG(Structure):
    _pack_ = 1;                     # 设置压缩存储
    _fields_ = [("systm", tagSYSTEMTIME),
                ("stationID", c_ulong),
                ("channelID", c_ulong),
                ("deviceID", c_ulong),
                ("grouphandle", c_ulong),
                ("num", c_ulong),
                ("arrPara", (c_ulong)*16),
                ("souid", c_ulong),
                ("arrVal", (c_double)*16)];
# 事件记录结构体定义   
class tagEVENTLOG(Structure):
    _pack_ = 1;                     # 设置压缩存储
    _fields_ = [("id", c_ulong),
                ("time", c_ulong),
                ("msec", c_ulong),
                ("alarm_class", c_ulong),
                ("alarm_type", c_ulong),
                ("alarm_byte", c_ulong),
                ("station_id", c_ulong),
                ("channel_id", c_ulong),
                ("device_id", c_ulong),
                ("station_flag", c_ubyte),
                ("code1", c_ulong),
                ("code2", c_ulong),
                ("evestr1", c_char * 256),
                ("evestr2", c_char * 256),
                ("information", c_char * 256),
                ("computername", c_char * 128)];
                
class tagWFORMLOG(Structure):
    _pack_ = 1;
    _fields_ = [("systm", tagSYSTEMTIME),
               ("station", c_ulong),
               ("channel", c_ulong),
               ("device", c_ulong),
               ("loghandle", c_ulong),
               ("nCompressed", c_ulong),
               ("hdrfilelen", c_ulong),
               ("hdrfile", c_char_p),
               ("cfgfilelen", c_ulong),
               ("cfgfile", c_char_p),
               ("datfilelen", c_ulong),
               ("datfile", c_char_p),
               ("inffilelen", c_ulong),
               ("inffile", c_char_p)];