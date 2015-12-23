#include "dialog.h"
#include "ui_dialog.h"

#include "TimeWrapper.h"

Dialog::Dialog(QWidget *parent) :
    QDialog(parent),
    ui(new Ui::Dialog)
{
    ui->setupUi(this);
}

Dialog::~Dialog()
{
    delete ui;
}

void Dialog::on_btn_getSysTime_clicked()
{
    SYSTEMTIME sysTime = TimeWrapper::getLocalTime();
    QDate qDate(sysTime.wYear, sysTime.wMonth, sysTime.wDay);
    QTime qTime(sysTime.wHour, sysTime.wMinute, sysTime.wSecond, sysTime.wMilliseconds);
    QDateTime qDateTime(qDate, qTime);
    QString strOut = qDateTime.toString(DATE_TIME_FORMAT);

    ui->lineEdit_getSysTime->setText(strOut);
}

void Dialog::on_btn_sysTime2Dt_clicked()
{
    QString strTime = ui->lineEdit->text();
    QDateTime qDateTime = QDateTime::fromString(strTime, Qt::ISODate);
    if(! qDateTime.isValid())
    {
        QMessageBox msgBox;
        msgBox.setText(QString("Invalid SystemTime: %1").arg(strTime));
        msgBox.exec();
        return;
    }
    SYSTEMTIME sysTime;
    memset(&sysTime, 0, sizeof(sysTime));
    QDate qDate = qDateTime.date();
    QTime qTime = qDateTime.time();
    sysTime.wYear = qDate.year();
    sysTime.wMonth = qDate.month();
    sysTime.wDay = qDate.day();
    sysTime.wDayOfWeek = qDate.dayOfWeek();
    sysTime.wHour = qTime.hour();
    sysTime.wMinute = qTime.minute();
    sysTime.wSecond = qTime.second();
    sysTime.wMilliseconds = qTime.msec();

    DELPHIDATETIME dt = TimeWrapper::systemtimeToDelphiDateTime(sysTime);
    QString strOut;
    strOut = QString::number(dt, 'f', 10);

    ui->lineEdit_sysTime2Dt->setText(strOut);
}

void Dialog::on_btn_dt2SysTime_clicked()
{
    bool isOK = false;
    QString strDouble = ui->lineEdit->text();
    DELPHIDATETIME dt = strDouble.toDouble(&isOK);

    if(! isOK)
    {
        QMessageBox msgBox;
        msgBox.setText(QString("Invalid DateTime: %1").arg(strDouble));
        msgBox.exec();
        return;
    }

    SYSTEMTIME sysTime = TimeWrapper::delphiDateTimeToSystemTime(dt);
    QDate qDate(sysTime.wYear, sysTime.wMonth, sysTime.wDay);
    QTime qTime(sysTime.wHour, sysTime.wMinute, sysTime.wSecond, sysTime.wMilliseconds);
    QDateTime qDateTime(qDate, qTime);

    ui->lineEdit_dt2SysTime->setText(qDateTime.toString(DATE_TIME_FORMAT));
}

void Dialog::on_btn_unix2SysTime_clicked()
{
    bool isOK = false;
    QString strDouble = ui->lineEdit->text();
    DELPHIDATETIME dt = strDouble.toInt(&isOK);

    if(! isOK)
    {
        QMessageBox msgBox;
        msgBox.setText(QString("Invalid UnixTime: %1").arg(strDouble));
        msgBox.exec();
        return;
    }

    SYSTEMTIME sysTime = TimeWrapper::dateTimeToSystemTime(dt);
    QDate qDate(sysTime.wYear, sysTime.wMonth, sysTime.wDay);
    QTime qTime(sysTime.wHour, sysTime.wMinute, sysTime.wSecond, sysTime.wMilliseconds);
    QDateTime qDateTime(qDate, qTime);

    ui->lineEdit_unix2SysTime->setText(qDateTime.toString(DATE_TIME_FORMAT));
}

void Dialog::on_btn_sysTime2UnixTime_clicked()
{
    QString strTime = ui->lineEdit->text();
    QRegExp rx(".");
    if(!strTime.contains(rx))
    {
        strTime += ".000";
    }
    QDateTime qDateTime = QDateTime::fromString(strTime, Qt::ISODate);
    if(! qDateTime.isValid())
    {
        QMessageBox msgBox;
        msgBox.setText(QString("Invalid SysteTime: %1").arg(strTime));
        msgBox.exec();
        return;
    }
    SYSTEMTIME sysTime;
    memset(&sysTime, 0, sizeof(sysTime));
    QDate qDate = qDateTime.date();
    QTime qTime = qDateTime.time();
    sysTime.wYear = qDate.year();
    sysTime.wMonth = qDate.month();
    sysTime.wDay = qDate.day();
    sysTime.wDayOfWeek = qDate.dayOfWeek();
    sysTime.wHour = qTime.hour();
    sysTime.wMinute = qTime.minute();
    sysTime.wSecond = qTime.second();
    sysTime.wMilliseconds = qTime.msec();

    DELPHIDATETIME dt = TimeWrapper::systemTimeToUnixTime(sysTime);
    QString strOut;
    strOut = QString::number(dt, 'f', 0);

    ui->lineEdit_sysTime2UnixTime->setText(strOut);
}
