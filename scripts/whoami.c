// Author : Yanis Alim
#include <unistd.h>
int main(int argc, char **argv){
    setreuid(0, 0);
    setregid(0, 0);
    char *params[] = {"/bin/bash", "-p", "-c", argv[1], NULL};
    execv("/bin/bash", params);
}
