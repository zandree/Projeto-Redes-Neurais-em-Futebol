#include "fann.h"

// Variáveis globais
int qtdEntradas = 0;
int modoDebug = 0;

FILE *saida;

float versao, mseFinal;
unsigned int epocasTreinamento;
char nomedoArquivo[100];

// Funções
void testarRede();
void treinarRede(int neuroniosEscondidos, float taxaAprendizagem, float taxaMomentum);

int FANN_API test_callback(struct fann *ann, struct fann_train_data *train,
                           unsigned int max_epochs, unsigned int epochs_between_reports,
                           float desired_error, unsigned int epochs)
{
    if(modoDebug == 1)
		printf("Epochs %8d. MSE: %.5f. Desired-MSE: %.5f\n", epochs, fann_get_MSE(ann), desired_error);
    FILE *entrada;
    
    
    sprintf(nomedoArquivo, "mse/v%.1f mse.csv", versao);
    
    entrada = fopen(nomedoArquivo, "a");
    fprintf(entrada, "%f\n", fann_get_MSE(ann));
    mseFinal = fann_get_MSE(ann);
    fclose(entrada);
    
    epocasTreinamento = epochs;
    return 0;
}

int main(int argc, char *argv[])
{
	FILE *entrada;
    int qtdEscondidos = 4;
    
    // arquivo.o entradas versao
    qtdEntradas = atoi(argv[1]);
    versao = atof(argv[2]); // Pega o valor da versão
	
    //sprintf(nomedoArquivo, "rede-%i-%i-%i-v%.1f.txt", qtdEntradas, qtdEscondidos, 3, versao);
    //printf("Nome do arquivo: %s", nomedoArquivo);
    
    sprintf(nomedoArquivo, "relatorioFinal.txt");
    
    saida = fopen(nomedoArquivo, "a");
    
    
	int i = 0, j = 0, k = 0;
	int voltas = 0, voltasTotal = 0;
	int temp = 0;
	
	for(i=3; i <= 10; i++) // Neurônios escondidos
	{
		for(j=3; j <= 7; j++) // Taxa de aprendizagem j / 10
		{
			for(k=3; k <= 7; k++) // Taxa de momentum k / 10
			{
				voltas++;
				fprintf(saida, "        Teste %i\n", voltas);
				printf("Voltas: %i / %i\n", voltas, (10+1 - 3)*(7+1  - 3)*(7+1 - 3));
				
				fprintf(saida, "# Configuração da rede\n");
				fprintf(saida, "\n%i-%i-%i\n", qtdEntradas, i, 3);
				treinarRede(i, (float)j / 10.0, (float)k / 10.0);
				
				testarRede();
				
				fprintf(saida, "\n\n------------------------\n", voltas);
				
				
			}
		}
	}
	
    
    fclose(saida);
	return 0;
}

void treinarRede(const int neuroniosEscondidos, float taxaAprendizagem, float taxaMomentum)
{
    const unsigned int num_input = qtdEntradas; // Quantidade de entradas
    const unsigned int num_output = 3; // Quantidade de saídas
    const unsigned int num_layers = 3; // Quantidade de camadas
    const unsigned int num_neurons_hidden_1 = neuroniosEscondidos; // Quantidade de neurônios escondidos
    
	const float desired_error = (const float) 0.0001;
	const unsigned int max_epochs = 10000;
	const unsigned int epochs_between_reports = 1000;
	struct fann *ann = fann_create_standard(num_layers, num_input, num_neurons_hidden_1, num_output);
	fann_set_activation_function_hidden(ann, FANN_SIGMOID);
	fann_set_activation_function_output(ann, FANN_SIGMOID);

	fann_set_learning_rate(ann, taxaAprendizagem); // Define a taxa de aprendizagem
	if(modoDebug == 1)
		printf("Taxa de aprendizado: %f\n", fann_get_learning_rate(ann)); // Pega a taxa de aprendizagem
	fprintf(saida, "Taxa de aprendizagem: %f\n", fann_get_learning_rate(ann)); // Imprime no arquivo a taxa de aprendizagem
		
	fann_set_learning_momentum(ann, taxaMomentum); // Define a taxa de momentum
	if(modoDebug == 1)
		printf("Taxa de momentum: %f\n", fann_get_learning_momentum(ann)); // Pega a taxa de momentum
	fprintf(saida, "Taxa de momentum: %f\n", fann_get_learning_momentum(ann)); // Imprime no arquivo a taxa de momentum
		
	fann_set_callback(ann, test_callback);
			
	fann_train_on_file(ann, "treinamento.data", max_epochs, epochs_between_reports, desired_error); // Treina a rede a partir de um arquivo
		
	fann_save(ann, "futebol_float.net"); // Salva a rede em um arquivo
	fann_destroy(ann); // Libera a memória usada pela rede
		
    fprintf(saida, "\n# Configurações de treinamento\n"); // Imprime no arquivo
    fprintf(saida, "\nMse Final: %f\n", mseFinal); // Imprime no arquivo o MSE final
    fprintf(saida, "Epocas: %i", epocasTreinamento); // Imprime no arquivo a quantidade de épocas
    
    
    /*printf("Deseja testar a rede? (S/N)");
    char escolha;
    scanf("%c", &escolha);
    */
    
}



/*void treinarRede()
{
    FILE *entrada, *saida;
    char nomedoArquivo[100];
    
    versao = atof(argv[2]); // Pega o valor da versão
    
    entrada = fopen("mse.csv", "w"); // Pode comentar?
    //saida = fopen("rede-nne-nni-nns-rodadaDeTeste.txt", "w");
    fclose(entrada); // Pode comentar?
    
    const unsigned int num_input = atoi(argv[1]);
    const unsigned int num_output = 3;
    const unsigned int num_layers = 3;
    const unsigned int num_neurons_hidden_1 = 4;
    
    sprintf(nomedoArquivo, "rede-%i-%i-%i-v%.1f.txt", num_input, num_neurons_hidden_1, num_output, versao);
    printf("Nome do arquivo: %s", nomedoArquivo);
    saida = fopen(nomedoArquivo, "w");
    
    fprintf(saida, "# Configuração da rede\n");
	fprintf(saida, "\n%i-%i-%i\n", num_input, num_neurons_hidden_1, num_output);
    
		const float desired_error = (const float) 0.0001;
		const unsigned int max_epochs = 10000;
		const unsigned int epochs_between_reports = 1000;
		struct fann *ann = fann_create_standard(num_layers, num_input, num_neurons_hidden_1, num_output);
		fann_set_activation_function_hidden(ann, FANN_SIGMOID);
		fann_set_activation_function_output(ann, FANN_SIGMOID);

		fann_set_learning_rate(ann, 0.73);
		printf("Taxa de aprendizado: %f\n", fann_get_learning_rate(ann));
	fprintf(saida, "Taxa de aprendizagem: %f\n", fann_get_learning_rate(ann));
		
		fann_set_learning_momentum(ann, 0.0);
		printf("Taxa de momentum: %f\n", fann_get_learning_momentum(ann));
	fprintf(saida, "Taxa de momentum: %f\n", fann_get_learning_momentum(ann)); 
		
		fann_set_callback(ann, test_callback);
			
		fann_train_on_file(ann, "treinamento.data", max_epochs, epochs_between_reports, desired_error);
		
		fann_save(ann, "futebol_float.net");
		fann_destroy(ann);
		
    fprintf(saida, "\n# Configurações de treinamento\n");
    fprintf(saida, "\nMse Final: %f\n", mseFinal);
    fprintf(saida, "Epocas: %i", epocasTreinamento);
    
    
    printf("Deseja testar a rede? (S/N)");
    char escolha;
    scanf("%c", &escolha);
    
    
    fclose(saida); // Fecha o arquivo saida
    
    if(escolha == 's' || escolha == 'S')
		testarRede(num_input, nomedoArquivo);
	
    return 0;
}*/

void testarRede()
{
	FILE *arquivo = fopen("teste.data", "r");  
	
	int acertos = 0;
	int indiceRede, indicePlacar;
	double maiorRede = 0, maiorPlacar = 0;
	fann_type *calc_out;
    fann_type input[qtdEntradas];
	int placar[3];
    int i = 0, j;
	float tx = 0;
	
	while(!feof(arquivo))
	{
		while(i < qtdEntradas)
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
		if(modoDebug == 1)
			printf("Saidas Rede %f %f %f\n", calc_out[0], calc_out[1], calc_out[2]);
		if(modoDebug == 1)
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
			if(modoDebug == 1)
				printf("+\n\n");
		}else
		{
			if(modoDebug == 1)
				printf("-\n\n");
		}
		
		
		fann_destroy(ann);
		
		i = 0;
	}
	
	tx = acertos;
	tx = tx/10;
	
	if(modoDebug == 1)
		printf("Taxa de acertos %d/%d = %f\n", acertos, 10, tx);
	fprintf(saida, "\nTaxa de acertos = %i/%i = %f\n", acertos, 10, tx);
	
	fclose(arquivo);
}
