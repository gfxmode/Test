#-------------------------------------------------
#
# Project created by QtCreator 2015-12-15T14:34:23
#
#-------------------------------------------------

QT       += core gui

greaterThan(QT_MAJOR_VERSION, 4): QT += widgets

TARGET = TimeConvertor
TEMPLATE = app

INCLUDEPATH += LIB


SOURCES += main.cpp\
        dialog.cpp \
    LIB/TimeWrapper.cpp

HEADERS  += dialog.h \
    LIB/TimeWrapper.h

FORMS    += dialog.ui
