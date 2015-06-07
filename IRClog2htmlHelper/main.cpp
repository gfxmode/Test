/*
 * Purpose: if there is an %Y-%m-%d.log, then call *irclog2html.py* converting *.log to *.html
 * Procedure:
 *      1. cd to irssi log folder, get folder names start with *#*
 *      2. with argv[1] "-a", get *.log. If *.log does not have a corresponding *.html file, then do irclog2html
 *      3. convert *.log today file to *.html
 *
 * argv:
 *      -a: do prcedure 1, 2, 3, 4
 *      default: do procedure 1, 3, 4
 */

#include <QCoreApplication>
#include <QDirIterator>
#include <QProcess>
#include <QDateTime>

#define IRSSI_LOG_FOLDER_PATH "/var/log/irssi/"

void getIrssiLogFolderName(QList<QString> &lsFolderName);
QString convertAllLogToHtml(const QList<QString> &lsFolderName);
QString convertTodayLogToHtml(const QList<QString> &lsFolderName);

int main(int argc, char *argv[])
{
    QList<QString> lsIrssiLogFolderName;
    lsIrssiLogFolderName.clear();
    // Process which do irclog2html Convert
    QProcess proc;
    QString strCMD;

    // Step1: get folder name start with "#"
    getIrssiLogFolderName(lsIrssiLogFolderName);

    // Step2: get *.log. If *.log does not have a corresponding *.html file, then do irclog2html
    QString strArgv;
    if(argc > 1)
    {
        strArgv = QString(QLatin1String(argv[1]));
        if(strArgv.contains('a'))
        {
            strCMD = "irclog2html " + convertAllLogToHtml(lsIrssiLogFolderName);
            if(strCMD.length() > 12)
            {
                proc.start(strCMD);
                proc.waitForFinished(1000);
            }
        }
    }

    // Step3: convert *.log today file to *.html
    strCMD = "irclog2html " + convertTodayLogToHtml(lsIrssiLogFolderName);
    if(strCMD.length() > 12)
    {
        proc.start(strCMD);
        proc.waitForFinished(1000);
    }

    return 0;
}

void getIrssiLogFolderName(QList<QString> &lsFolderName)
{
    QDir dir(IRSSI_LOG_FOLDER_PATH);
    QFileInfo fileInfo;
    QFileInfoList list;

    dir.setFilter(QDir::Dirs | QDir::NoSymLinks);
    list = dir.entryInfoList();
    for (int i = 0; i < list.size(); i++)
    {
        fileInfo = list.at(i);
        // if folderName start with '#', it is a irssi log folder
        if(fileInfo.fileName().startsWith('#'))
        {
            lsFolderName.append(fileInfo.absoluteFilePath());
        }
    }
}

QString convertAllLogToHtml(const QList<QString> &lsFolderName)
{
    QString strFolderPath;
    QFileInfo fileInfo;
    QFileInfoList list;
    QString strFileToConvert = "";

    for(int i = 0; i < lsFolderName.size(); i++)
    {
        strFolderPath = lsFolderName.at(i);
        QDir dir(strFolderPath);
        dir.setFilter(QDir::Files | QDir::NoSymLinks);
        list = dir.entryInfoList();

        for(int j = 0; j < list.size(); j++)
        {
            fileInfo = list.at(j);

            if(fileInfo.fileName().endsWith("log"))
            {
                if(! list.contains(fileInfo.absoluteFilePath()+".html"))
                {
                    strFileToConvert += fileInfo.absoluteFilePath() + " ";
                }
            }
        }
    }

    return strFileToConvert;
}

QString convertTodayLogToHtml(const QList<QString> &lsFolderName)
{
    QDateTime now = QDateTime::currentDateTime();
    QString strTodayLogName = now.toString("yyyy-MM-dd.log");
    QString strFilePath;
    QFileInfo fileInfo;
    QString strFileToConvert = "";

    for(int i = 0; i < lsFolderName.size(); i++)
    {
        strFilePath = lsFolderName.at(i) + '/' + strTodayLogName;
        fileInfo.setFile(strFilePath);
        if(fileInfo.isFile())
        {
            // make abslute file path
            strFileToConvert += strFilePath + " ";
        }
    }

    return strFileToConvert;
}
