using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Data;
using System.IO;

namespace ConvertXlsToTxt.Handler
{
    class FileHandler
    {
        public static void writeStringToTxt(ref string txtPath, ref string txtContent)
        {
            File.WriteAllText(txtPath, txtContent);
        }

        public static string exportDataSetToString(ref DataSet dsData)
        {
            StringBuilder sbResult = new StringBuilder();
            foreach (DataTable dt in dsData.Tables)
            {
                int cntCol = dt.Columns.Count;
                foreach (DataRow dr in dt.Rows)
                {
                    for (int i = 0; i < cntCol; ++i)
                    {
                        sbResult.Append(Convert.ToString(dr[i])).Append(",");
                    }
                }
            }

            return sbResult.ToString();
        }
    }
}
