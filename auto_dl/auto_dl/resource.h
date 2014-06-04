/* 
 * File:   resource.h
 * Author: Àlex
 *
 * Created on 30 de mayo de 2014, 14:49
 */

#ifndef RESOURCE_H
#define	RESOURCE_H

#include <windows.h>
//#include <shellapi.h>

#define BUTTON1 100 // I used 100 as an example you can use any number
#define ICO1 101
//#define ID_BUTTON   102

#define ID_TRAY_APP_ICON    1001
#define ID_TRAY_EXIT        1002
#define ID_TRAY_OPEN        1003
#define WM_SYSICON          (WM_USER + 1)

std::map<std::string, std::string> options; // global?
//std::ifstream myfile ("canborrell_download.cfg");
void parse(std::ifstream & cfgfile);

std::string login_url = "xxxhttp://cbdev.localhost/taules/index.php?cpp";
std::string dl_url = "xxxhttp://cbdev.localhost/taules/print.php?a=torn&p";
std::string img_url = "xxxhttp://cbdev.localhost/taules/print/print.png";
std::string usr = "xxxxalex";
std::string pass = "xxxxAlkaline10";
int interval_segons = 10;
char outfilename[FILENAME_MAX] = "llistat_reserves.html";
CURL *curl;


UINT WM_TASKBAR = 0;
HWND Hwnd;
HMENU Hmenu;
NOTIFYICONDATA notifyIconData;
TCHAR szTIP[64] = TEXT("Can Borrell Auto Download");
char szClassName[ ] = "Descarrega de llistat de reserves";
static HINSTANCE ghInstance = NULL;
int NCmdShow;
std::string iniciaSessio();
int writer(char *data, size_t size, size_t nmemb, std::string *buffer);
size_t write_data(void *ptr, size_t size, size_t nmemb, FILE *stream);
void threads();
/*procedures  */
LRESULT CALLBACK WindowProcedure(HWND, UINT, WPARAM, LPARAM);
void minimize();
void restore();
void InitNotifyIconData();
void obreLlistat(HWND hwnd);
const std::string currentDateTime();
HICON CreateSmallIcon( HWND hWnd );
void UpdateIcon(HWND hWnd);

#endif	/* RESOURCE_H */