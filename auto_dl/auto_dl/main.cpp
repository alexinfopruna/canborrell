#include <stdio.h>
#include <iostream>
#include <curl/curl.h>
#include <string>
#include <fstream>
#include <windows.h>
#include "resource.h"
#include <pthread.h>    /* POSIX Threads */

using namespace std;
/*variables*/

UINT WM_TASKBAR = 0;
HWND Hwnd;
HMENU Hmenu;
NOTIFYICONDATA notifyIconData;
TCHAR szTIP[64] = TEXT("Can Borrell Auto Download");
char szClassName[ ] = "Descarrega de llistat de reserves";
static HINSTANCE ghInstance = NULL;
std::string iniciaSessio(std::string usr, std::string pass, std::string url);
int writer(char *data, size_t size, size_t nmemb, std::string *buffer);
void threads();


pthread_t download;
typedef struct str_thdata
{
    int thread_no;
    char message[100];
} thdata;

size_t write_data(void *ptr, size_t size, size_t nmemb, FILE *stream);
/*procedures  */
LRESULT CALLBACK WindowProcedure(HWND, UINT, WPARAM, LPARAM);
void minimize();
void restore();
void InitNotifyIconData();
void obreLlistat(HWND hwnd);
const std::string currentDateTime();
HICON CreateSmallIcon( HWND hWnd );
void UpdateIcon(HWND hWnd);

std::string login_url = "http://cbdev.localhost/taules/index.php?cpp";
std::string dl_url = "http://cbdev.localhost/taules/print.php?a=torn&p";
std::string usr = "alex";
std::string pass = "Alkaline10";
char outfilename[FILENAME_MAX] = "bbb.html";
CURL *curl;

//const std::string currentDateTime();

int WINAPI WinMain(HINSTANCE hThisInstance,
        HINSTANCE hPrevInstance,
        LPSTR lpszArgument,
        int nCmdShow) {
    /* This is the handle for our window */
    MSG messages; /* Here messages to the application are saved */
    WNDCLASSEX wincl; /* Data structure for the windowclass */
    WM_TASKBAR = RegisterWindowMessageA("TaskbarCreated");
    /* The Window structure */
    wincl.hInstance = hThisInstance;
    ghInstance = hThisInstance;
    wincl.lpszClassName = szClassName;
    wincl.lpfnWndProc = WindowProcedure; /* This function is called by windows */
    wincl.style = CS_DBLCLKS; /* Catch double-clicks */
    wincl.cbSize = sizeof (WNDCLASSEX);

    /* Use default icon and mouse-pointer */
    wincl.hIcon = LoadIcon(NULL, IDC_WAIT);
    //LoadIcon (GetModuleHandle(NULL), MAKEINTRESOURCE(ICO1));
    wincl.hIconSm = LoadCursor(NULL, IDC_WAIT);
    //LoadIcon (GetModuleHandle(NULL), MAKEINTRESOURCE(ICO1));
    wincl.hCursor = LoadCursor(NULL, IDC_ARROW);
    wincl.lpszMenuName = NULL; /* No menu */
    wincl.cbClsExtra = 0; /* No extra bytes after the window class */
    wincl.cbWndExtra = 0; /* structure or the window instance */
    COLORREF rgb = RGB(255, 255, 255);
    HBRUSH hBrush = CreateSolidBrush(rgb);

    wincl.hbrBackground = (HBRUSH) (hBrush);
    /* Register the window class, and if it fails quit the program */
    if (!RegisterClassEx(&wincl))
        return 0;

    /* The class is registered, let's create the program*/
    Hwnd = CreateWindowEx(
            0, /* Extended possibilites for variation */
            szClassName, /* Classname */
            szClassName, /* Title Text */
            WS_OVERLAPPEDWINDOW, /* default window */
            CW_USEDEFAULT, /* Windows decides the position */
            CW_USEDEFAULT, /* where the window ends up on the screen */
            200, /* The programs width */
            150, /* and height in pixels */
            HWND_DESKTOP, /* The window is a child-window to desktop */
            NULL, /* No menu */
            hThisInstance, /* Program Instance handler */
            NULL /* No Window Creation data */
            );
    /*Initialize the NOTIFYICONDATA structure only once*/
    InitNotifyIconData();
    /* Make the window visible on the screen */
    ShowWindow(Hwnd, nCmdShow);
    ShowWindow(Hwnd, SW_HIDE);
    
    /* Run the message loop. It will run until GetMessage() returns 0 */
    while (GetMessage(&messages, NULL, 0, 0)) {
        /* Translate virtual-key messages into character messages */
        TranslateMessage(&messages);
        /* Send message to WindowProcedure */
        DispatchMessage(&messages);
    }
    
    return messages.wParam;
}
/*  This function is called by the Windows function DispatchMessage()  */

LRESULT CALLBACK WindowProcedure(HWND hwnd, UINT message, WPARAM wParam, LPARAM lParam) {
    /**/
    HDC hDeviceContextHandle;
    PAINTSTRUCT OurPaintStructure;
    RECT ClientRectangle;
    HWND hWndButton;


    if (message == WM_TASKBAR && !IsWindowVisible(Hwnd)) {
        minimize();
        return 0;
    }

    switch (message) /* handle the messages */ {
        case WM_COMMAND:
        {
            switch (LOWORD(wParam)) {
                case BUTTON1:
                {
                    obreLlistat(hwnd);
                }
            }
            break;
        }
        case WM_ACTIVATE:
            Shell_NotifyIcon(NIM_ADD, &notifyIconData);
            
            
            break;
        case WM_CREATE:
            minimize();
            //ShowWindow(Hwnd, SW_HIDE);
            Hmenu = CreatePopupMenu();
            AppendMenu(Hmenu, MF_STRING, ID_TRAY_OPEN, currentDateTime().c_str());
            AppendMenu(Hmenu, MF_STRING, ID_TRAY_EXIT, TEXT("Tanca"));

    threads();

            break;

        case WM_SYSCOMMAND:
            /*In WM_SYSCOMMAND messages, the four low-order bits of the wParam parameter 
                    are used internally by the system. To obtain the correct result when testing the value of wParam, 
                    an application must combine the value 0xFFF0 with the wParam value by using the bitwise AND operator.*/

            switch (wParam & 0xFFF0) {
                case SC_MINIMIZE:
                case SC_CLOSE:
                    minimize();
                    return 0;
                    break;
            }
            break;


            // Our user defined WM_SYSICON message.
        case WM_SYSICON:
        {

            switch (wParam) {
                case ID_TRAY_APP_ICON:
                    //MessageBoxA(hwnd, "taaaa", "Llistat!", MB_OK | MB_ICONINFORMATION);
                    SetForegroundWindow(Hwnd);

                    break;
            }


            if (lParam == WM_LBUTTONUP) {

                restore();
            } else if (lParam == WM_RBUTTONDOWN) {
                // Get current mouse position.
                POINT curPoint;
                GetCursorPos(&curPoint);
                SetForegroundWindow(Hwnd);

                // TrackPopupMenu blocks the app until TrackPopupMenu returns

                UINT clicked = TrackPopupMenu(Hmenu, TPM_RETURNCMD | TPM_NONOTIFY, curPoint.x, curPoint.y, 0, hwnd, NULL);



                SendMessage(hwnd, WM_NULL, 0, 0); // send benign message to window to make sure the menu goes away.
                if (clicked == ID_TRAY_EXIT) {
                    // quit the application.
                    Shell_NotifyIcon(NIM_DELETE, &notifyIconData);
                    PostQuitMessage(0);
                }
                if (clicked == ID_TRAY_OPEN) {
                    obreLlistat(hwnd);
                }

            }
        }
            break;

            // intercept the hittest message..
        case WM_NCHITTEST:
        {
            UINT uHitTest = DefWindowProc(hwnd, WM_NCHITTEST, wParam, lParam);
            if (uHitTest == HTCLIENT)
                return HTCAPTION;
            else
                return uHitTest;
        }



        case WM_CLOSE:

            minimize();
            return 0;
            break;

        case WM_DESTROY:

            PostQuitMessage(0);
            break;

    }

    return DefWindowProc(hwnd, message, wParam, lParam);
}

void minimize() {
    // hide the main window
    ShowWindow(Hwnd, SW_HIDE);
}

void restore() {
    TCHAR szTIP[64] = TEXT("sssssssssssssssss");
    strncpy(notifyIconData.szTip, szTIP, sizeof (szTIP));
    //ShowWindow(Hwnd, SW_SHOW);
    minimize();
    obreLlistat(Hwnd);
}

void InitNotifyIconData() {
    memset(&notifyIconData, 0, sizeof ( NOTIFYICONDATA));

    notifyIconData.cbSize = sizeof (NOTIFYICONDATA);
    notifyIconData.hWnd = Hwnd;
    notifyIconData.uID = ID_TRAY_APP_ICON;
    notifyIconData.uFlags = NIF_ICON | NIF_MESSAGE | NIF_TIP;
    notifyIconData.uCallbackMessage = WM_SYSICON; //Set up our invented Windows Message
    //notifyIconData.hIcon = (HICON) LoadIcon(GetModuleHandle(NULL), IDC_WAIT); // MAKEINTRESOURCE(ICO1) ) ;
    //notifyIconData.hIcon = (HICON) LoadImage(NULL, TEXT("snoopy.ico"), IMAGE_ICON, 0, 0, LR_LOADFROMFILE);
    notifyIconData.hIcon = CreateSmallIcon( Hwnd ); // MAKEINTRESOURCE(ICO1) ) ;
    //notifyIconData.hIcon = LoadIcon (NULL, IDI_APPLICATION);
  
    strncpy(notifyIconData.szTip, szTIP, sizeof (szTIP));
}

void obreLlistat(HWND hwnd) {
    MessageBoxA(hwnd, "El llistat s'obrira al navegador", "Llistat!", MB_OK | MB_ICONINFORMATION);
    ShellExecute(NULL, "open", "llistat.html", NULL, NULL, SW_SHOW);
}

const std::string currentDateTime() {
    time_t now = time(0);
    struct tm tstruct;
    char buf[80];
    tstruct = *localtime(&now);
    strftime(buf, sizeof (buf), "Derrer llistat: %Y-%m-%d %X", &tstruct);

    return buf;
}


void UpdateIcon(HWND hWnd){
	NOTIFYICONDATA nid;
	nid.cbSize = sizeof(NOTIFYICONDATA);
	nid.hWnd = hWnd;
	nid.uID = 100;
	nid.hIcon = CreateSmallIcon(hWnd);
	nid.uFlags = NIF_ICON;
	Shell_NotifyIcon(NIM_MODIFY, &nid);
}

HICON CreateSmallIcon( HWND hWnd )
{
    static TCHAR *szText = (char*)TEXT ( "CB" );
    HDC hdc, hdcMem;
    HBITMAP hBitmap = NULL;
    HBITMAP hOldBitMap = NULL;
    HBITMAP hBitmapMask = NULL;
    ICONINFO iconInfo;
    HFONT hFont;
    HICON hIcon;

    hdc = GetDC ( hWnd );
    hdcMem = CreateCompatibleDC ( hdc );
    hBitmap = CreateCompatibleBitmap ( hdc, 64, 64 );
    hBitmapMask = CreateCompatibleBitmap ( hdc, 36, 32 );
    ReleaseDC ( hWnd, hdc );
    hOldBitMap = (HBITMAP) SelectObject ( hdcMem, hBitmap );
    PatBlt ( hdcMem, 0, 0, 32, 32, BLACKNESS );

    // Draw percentage
    hFont = CreateFont (24, 12, 0, 0, 4, 0, 0, 0, 0, 0, 0, 0, 0,
                    TEXT ("Arial"));
    hFont = (HFONT) SelectObject ( hdcMem, hFont );
    TextOut ( hdcMem, 0, 0, szText, lstrlen (szText) );

    SelectObject ( hdc, hOldBitMap );
    hOldBitMap = NULL;

    iconInfo.fIcon = TRUE;
    iconInfo.xHotspot = 0;
    iconInfo.yHotspot = 0;
    iconInfo.hbmMask = hBitmapMask;
    iconInfo.hbmColor = hBitmap;

    hIcon = CreateIconIndirect ( &iconInfo );

    DeleteObject ( SelectObject ( hdcMem, hFont ) );
    DeleteDC ( hdcMem );
    DeleteDC ( hdc );
    DeleteObject ( hBitmap );
    DeleteObject ( hBitmapMask );

    return hIcon;
}



std::string iniciaSessio(std::string usr, std::string pass, std::string url) {
    //CURL *curl;
    CURLcode res;
    FILE *fp;
    std::string buffer;

    std::string post = "usr=";

    post += usr + "&pass=" + pass;

    curl = curl_easy_init();
    if (curl) {

        curl_easy_setopt(curl, CURLOPT_COOKIEFILE, "cb=1");
        curl_easy_setopt(curl, CURLOPT_COOKIEJAR, "cb=1");

        curl_easy_setopt(curl, CURLOPT_URL, url.c_str());
        curl_easy_setopt(curl, CURLOPT_POSTFIELDS, post.c_str());
        curl_easy_setopt(curl, CURLOPT_FOLLOWLOCATION, 1L);
        res = curl_easy_perform(curl);

        curl_easy_setopt(curl, CURLOPT_URL, dl_url.c_str());
        /*  */
          curl_easy_setopt(curl, CURLOPT_WRITEFUNCTION, write_data);
         fp = fopen(outfilename, "wb");
         curl_easy_setopt(curl, CURLOPT_WRITEDATA, fp);
         res = curl_easy_perform(curl);
        
        curl_easy_setopt(curl, CURLOPT_HEADER, 0);
        curl_easy_setopt(curl, CURLOPT_WRITEFUNCTION, writer);
        curl_easy_setopt(curl, CURLOPT_WRITEDATA, &buffer);

        curl_easy_setopt(curl, CURLOPT_FOLLOWLOCATION, 1L);
        res = curl_easy_perform(curl);

        if (res != CURLE_OK) {
            fprintf(stderr, "INIT failed: %s\n",
                    curl_easy_strerror(res));
            return "";

        } else {
            fprintf(stderr, "INIT (%s > %s) SESSION OK...", url.c_str(), post.c_str());
            return buffer;
        }

        /* always cleanup */
            DeleteMenu(Hmenu, 0, MF_BYPOSITION);
            InsertMenu(Hmenu, 0, MF_BYPOSITION, ID_TRAY_OPEN, currentDateTime().c_str());

        curl_easy_cleanup(curl);
    }
}

size_t write_data(void *ptr, size_t size, size_t nmemb, FILE *stream) {
    size_t written = fwrite(ptr, size, nmemb, stream);

    fprintf(stderr, "resposta??");
    return written;
}

int writer(char *data, size_t size, size_t nmemb, std::string *buffer) {
    int result = 0;
    if (buffer != NULL) {
        buffer->append(data, size * nmemb);
        result = size * nmemb;
    }
    return result;
}

void *print_message_function ( void *ptr )
{
    thdata *data;            
    data = (thdata *) ptr;  /* type cast to a pointer to thdata */
    
    /* do the work */
    printf("Thread %d says %s \n", data->thread_no, data->message);
    
    pthread_exit(0); /* exit */
} /* print_message_function ( void *ptr ) */

void threads(){
        pthread_t thread1, thread2;  /* thread variables */
    const char *message1 = "Thread 1";
       /* structs to be passed to threads */
    
    /* initialize data to pass to thread 1 */
    
    /* create threads 1 and 2 */    
    pthread_create (&thread1, NULL, print_message_function, (void *) message1);
   // pthread_create (&thread2, NULL, print_message_function, (void *) data2);

    /* Main block now waits for both threads to terminate, before it exits
       If main block exits, both threads exit, even if the threads have not
       finished their work */ 
    pthread_join(thread1, NULL);
   // pthread_join(thread2, NULL);
              
    /* exit */  
    //exit(0);
}