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

'''
数据结构定义
'''
# 数据序号，索引块
class tagDTSNINDEX(Structure):
    _fields_ = [("logtype", c_ushort),
                ("reserved1", c_ushort),
                ("datfileid", c_ulong),
                ("datfilepos", c_ulong),
                ("logidhi", c_ulong),
                ("logidlo", c_ulong),
                ("loglen", c_ulong),
                ("logcrc", c_ulong),
                ("reserved2", c_ushort),
                ("sumcrc", c_ushort)]
    
class tagDATALOG(Structure):
    _fields_ = [("systm", c_uint16 * 8),
                ("stationID", c_ulong),
                ("channelID", c_ulong),
                ("deviceID", c_ulong),
                ("grouphandle", c_ulong),
                ("num", c_ulong),
                ("arrPara", (c_ulong)*16),
                ("souid", c_ulong),
                ("arrVal", (c_double)*16)]