#include <stdio.h>
#include <iostream>
#include <curl/curl.h>
#include <string>
#include <fstream>
#include <windows.h>

#include "resource.h"




void *print_message_function ( void *ptr )
{
     /* do the work */
    printf("Thread  says holaaaa\n");
    
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