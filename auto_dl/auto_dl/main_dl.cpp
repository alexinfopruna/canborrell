#include <stdio.h>
#include <iostream>
#include <curl/curl.h>
#include <string>
#include <fstream>
#include <windows.h>


using namespace std;
string iniciaSessio(string usr, string pass, string url);
int writer(char *data, size_t size, size_t nmemb, string *buffer);
size_t write_data(void *ptr, size_t size, size_t nmemb, FILE *stream);

string login_url = "http://cbdev.localhost/taules/index.php?cpp";
string dl_url = "http://cbdev.localhost/taules/print.php?a=torn&p";
string usr = "alex";
string pass = "Alkaline10";
char outfilename[FILENAME_MAX] = "bbb.html";
CURL *curl;
bool tramitant_peticio;


int main_dl(void) {
    bool result = false;
    FILE *fp;
    tramitant_peticio = false;

    while (!result) {
        string buffer;
        buffer = iniciaSessio(usr, pass, login_url);
        cout << buffer << endl;


        ofstream myfile;
        myfile.open(outfilename);
        myfile << buffer << "\n" << endl;
        myfile.close();

        Sleep(10000);
    }
}

string iniciaSessio(string usr, string pass, string url) {
    //CURL *curl;
    CURLcode res;
    FILE *fp;
    string buffer;

    string post = "usr=";

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
        /* 
          curl_easy_setopt(curl, CURLOPT_WRITEFUNCTION, write_data);
         fp = fopen(outfilename, "wb");
         curl_easy_setopt(curl, CURLOPT_WRITEDATA, fp);
         res = curl_easy_perform(curl);
         */
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
        curl_easy_cleanup(curl);
    }
}

size_t write_data(void *ptr, size_t size, size_t nmemb, FILE *stream) {
    size_t written = fwrite(ptr, size, nmemb, stream);

    fprintf(stderr, "resposta??");
    return written;
}

int writer(char *data, size_t size, size_t nmemb, string *buffer) {
    int result = 0;
    if (buffer != NULL) {
        buffer->append(data, size * nmemb);
        result = size * nmemb;
    }
    return result;
}