using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using ConvertXlsToTxt.Handler;
using System.Data;

namespace ConvertXlsToTxt
{
    class Program
    {
        static void Main(string[] args)
        {
            /************************************************************************/
            /* Beyond compare传参 %srcFile %targetFile                              */
            /************************************************************************/
            if (args.Length < 2)
            {
                LOG.instance.Error("args invalid. args length short than 2");

                return;
            }

            // get ssrcFile
            string strXlsPath = args[0];
            // get targetFile
            string strTxtPath = args[1];

            DataSet dsExcel = ExcelHandler.readExcel2DataSet(strXlsPath, false);
            if (null == dsExcel)
            {
                LOG.instance.Error(string.Format("Excel read error. ExcelPath={0}", args[0]));

                return;
            }

            string strDataSet = FileHandler.exportDataSetToString(ref dsExcel);
            FileHandler.writeStringToTxt(ref strTxtPath, ref strDataSet);
        }
    }
}
