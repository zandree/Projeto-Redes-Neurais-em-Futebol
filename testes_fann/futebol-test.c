#include <stdio.h>
#include "floatfann.h"
int main(int argc, char *argv[])
{
	FILE *arquivo = fopen("teste.data", "r");
	
	int entradas = atoi(argv[1]);
	int acertos = 0;
	int indiceRede, indicePlacar;
	double maiorRede = 0, maiorPlacar = 0;
	fann_type *calc_out;
    fann_type input[entradas];
	int placar[3];
    int i = 0, j;
	float tx = 0;
	while(!feof(arquivo))
	{
		while(i<(entradas))
		{
			fscanf(arquivo, "%f", &input[i]);
			//printf("%f ", input[i]);
			i++;
		}
		
		fscanf(arquivo, "%i", &placar[0]);
		fscanf(arquivo, "%i", &placar[1]);
		fscanf(arquivo, "%i", &placar[2]);
		
		struct fann *ann = fann_create_from_file("futebol_float.net");
		calc_out = fann_run(ann, input);
		printf("Saidas Rede %f %f %f\n", calc_out[0], calc_out[1], calc_out[2]);
		printf("Saidas Real %i %i %i ", placar[0], placar[1], placar[2]);
		
		//Calculo da taxa de acertos da rede
		maiorRede = 0;
		maiorPlacar = 0;
		for(j=0;j<3;j++)
		{
			if(calc_out[j]>maiorRede)
			{
				maiorRede = calc_out[j];
				indiceRede = j;
			}
			if(placar[j]>maiorPlacar)
			{
				maiorPlacar = placar[j];
				indicePlacar = j;
			}
		}
		
		if(indiceRede==indicePlacar)
		{
			acertos++;
			printf("+\n\n");
		}else
		{
			printf("-\n\n");
		}
		
		
		fann_destroy(ann);
		
		i = 0;
	}
	tx = acertos;
	tx = tx/10;
	printf("Taxa de acertos %d/%d = %f\n", acertos, 10, tx);
	return 0;
}
