#ifndef DIALOG_H
#define DIALOG_H

#include <QDialog>
#include <QDate>
#include <QTime>
#include <QDateTime>
#include <QMessageBox>
#include <QLocale>

// I don't know how to get KDE's time format, use fixed time format
const QString DATE_TIME_FORMAT = "yyyy-MM-dd hh:mm:ss.zzz";

namespace Ui {
class Dialog;
}

class Dialog : public QDialog
{
    Q_OBJECT

public:
    explicit Dialog(QWidget *parent = 0);
    ~Dialog();

private slots:
    void on_btn_getSysTime_clicked();

    void on_btn_sysTime2Dt_clicked();

    void on_btn_dt2SysTime_clicked();

    void on_btn_unix2SysTime_clicked();

    void on_btn_sysTime2UnixTime_clicked();

private:
    Ui::Dialog *ui;
};

#endif // DIALOG_H
