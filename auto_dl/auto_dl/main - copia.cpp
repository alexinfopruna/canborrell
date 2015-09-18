#include "resource.h"
//#include "gui/interface.h"

/*variables*/
UINT WM_TASKBAR = 0;
HWND Hwnd;
HMENU Hmenu;
NOTIFYICONDATA notifyIconData;
TCHAR szTIP[64] = TEXT("Can Borrell Auto Download");
char szClassName[ ] = "Descarrega de llistat de reserves";
static HINSTANCE ghInstance = NULL;



/*procedures  */
LRESULT CALLBACK WindowProcedure(HWND, UINT, WPARAM, LPARAM);
void minimize();
void restore();
void InitNotifyIconData();
void obreLlistat(HWND hwnd);


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
    HWND BTN1;
    BTN1 = CreateWindowExW(NULL,
            L"BUTTON",
            L"Obrir llistat ",
            WS_VISIBLE | WS_CHILD | BS_DEFPUSHBUTTON, // Styles
            0, /*x*/
            50, /*y*/
            200, /*width*/
            24, /*height*/
            Hwnd,
            (HMENU) BUTTON1, //Button ID (Step 1)
            GetModuleHandle(NULL),
            NULL);

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
            /*   
        case WM_PAINT://Operating system wants to repaint our program window.
            // Beep(880,50);//typical test sound
            hDeviceContextHandle = BeginPaint(hwnd, &OurPaintStructure); //Based on
            //hOurWindowHandle this function fills OurPaintStructure.
            GetClientRect(hwnd, &ClientRectangle);
            //Fills ClientRectangle of hOurWindowHandle
            //window.
            DrawText(hDeviceContextHandle, "Hello, programming world!", -1, //Will type Hellow
                    //programming world in the middle
                    //of found ClientRectangle.
                    &ClientRectangle, DT_SINGLELINE | DT_CENTER | DT_VCENTER);
            //These flags center our text.
            EndPaint(hwnd, &OurPaintStructure); //The end of repainting.



            return 0;
 */
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
//minimize();
ShowWindow(Hwnd, SW_HIDE);
//ShowWindow(Hwnd, SW_HIDE);
            Hmenu = CreatePopupMenu();
            AppendMenu(Hmenu, MF_STRING, ID_TRAY_OPEN, TEXT("Obre llistat"));
            AppendMenu(Hmenu, MF_STRING, ID_TRAY_EXIT, TEXT("Tanca"));
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
}

void InitNotifyIconData() {
    memset(&notifyIconData, 0, sizeof ( NOTIFYICONDATA));

    notifyIconData.cbSize = sizeof (NOTIFYICONDATA);
    notifyIconData.hWnd = Hwnd;
    notifyIconData.uID = ID_TRAY_APP_ICON;
    notifyIconData.uFlags = NIF_ICON | NIF_MESSAGE | NIF_TIP;
    notifyIconData.uCallbackMessage = WM_SYSICON; //Set up our invented Windows Message
    notifyIconData.hIcon = (HICON) LoadIcon(GetModuleHandle(NULL), IDC_WAIT); // MAKEINTRESOURCE(ICO1) ) ;
    strncpy(notifyIconData.szTip, szTIP, sizeof (szTIP));
}

void obreLlistat(HWND hwnd){
                    MessageBoxA(hwnd, "El llistat s'obrira al navegador", "Llistat!", MB_OK | MB_ICONINFORMATION);
                    ShellExecute(NULL, "open", "llistat.html", NULL, NULL, SW_SHOW);

}
