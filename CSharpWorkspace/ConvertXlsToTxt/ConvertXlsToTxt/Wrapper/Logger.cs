/*
    说明：log4net封装类，线程安全，单例模式
    作者：gfxmode@live.com
    日期：2018-02-19
*/

using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using log4net;

/// <summary>
/// log4net封装类，线程安全，单例模式
/// 用法：LOG.instance.Debug\Info\Error，输出字符串
/// </summary>
public static class LOG
{
    public static ILog instance = log4net.LogManager.GetLogger("logger_info");
}

