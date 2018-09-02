using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Data;
using System.Data.OleDb;

namespace ConvertXlsToTxt.Handler
{
    class ExcelHandler
    {
        /// <summary>
        /// 获取 Excel 连接对象。
        /// </summary>
        /// <param name="strFullPath">文件的完全路径</param>
        /// <param name="isTreatedHeader">是否处理表头</param>
        /// <param name="intIMEXMode">输入输出模式。1：设置输入为文本 Text 类型，通常使用该值。0/2：设置输入为 多数 Majority 类型，此设置极易导致数据缺失发生。</param>
        /// <returns>Excel 连接对象</returns>
        public static OleDbConnection getExcelConnection( string excelPath, bool includeHeader, int IMEXMode)
        {
            string connectionString = @"Provider=Microsoft.ACE.OLEDB.12.0;Data Source={0};Extended Properties='Excel 12.0;HDR={1};IMEX={2};'";

            connectionString = string.Format( connectionString, excelPath, includeHeader ? "YES" : "NO", IMEXMode );

            return new OleDbConnection( connectionString );
        }

        /// <summary>
        /// 从Excel中读取数据
        /// </summary>
        /// <param name="filePath">文件路径</param>
        /// <param name="includeHeader">是否包含列信息，（第一行作为列）</param>
        /// <returns>excel包含的数据集</returns>
        public static DataSet readExcel2DataSet(string filePath, bool includeHeader)
        {
            OleDbConnection connection = getExcelConnection( filePath , includeHeader, 1);
            try
            {
                connection.Open();
                DataTable schemaTable = connection.GetOleDbSchemaTable(OleDbSchemaGuid.Tables,new object[] {null, null, null, "TABLE"});
                
                OleDbDataAdapter adapter = new OleDbDataAdapter();
                adapter.SelectCommand = new OleDbCommand();
                adapter.SelectCommand.Connection = connection;
                DataSet excelData = new DataSet();

                for( int i=0; i< schemaTable.Rows.Count; i++)
                {                    
                    DataRow dr = schemaTable.Rows[i];
                    adapter.SelectCommand.CommandText = string.Format("SELECT * FROM [{0}]", dr["TABLE_NAME"].ToString());
                    adapter.Fill(excelData);
                    excelData.Tables[i].TableName = dr["TABLE_NAME"].ToString();
                }

                return excelData;
            }
            catch (Exception ex)
            {
                LOG.instance.Error(ex.ToString());

                return null;
            }
            finally
            {
                if(connection != null)
                {
                    connection.Close();
                }
            }
        }
    }
}
