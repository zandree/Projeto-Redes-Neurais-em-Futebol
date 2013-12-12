#include "fann.h"
int FANN_API test_callback(struct fann *ann, struct fann_train_data *train,
                           unsigned int max_epochs, unsigned int epochs_between_reports,
                           float desired_error, unsigned int epochs)
{
    printf("Epochs     %8d. MSE: %.5f. Desired-MSE: %.5f\n", epochs, fann_get_MSE(ann), desired_error);
    FILE *entrada;
    entrada = fopen("mse.csv", "a");
    fprintf(entrada, "%f\n", fann_get_MSE(ann));
    fclose(entrada);
    return 0;
}

int main(int argc, char *argv[])
{
    FILE *entrada;
    entrada = fopen("mse.csv", "w");
    fclose(entrada);
    
    const unsigned int num_input = atoi(argv[1]);
    const unsigned int num_output = 3;
    const unsigned int num_layers = 3;
    const unsigned int num_neurons_hidden_1 = 4;
	//const unsigned int num_neurons_hidden_2 = 3;
    const float desired_error = (const float) 0.0001;
    const unsigned int max_epochs = 50000;
    const unsigned int epochs_between_reports = 5000;
    struct fann *ann = fann_create_standard(num_layers, num_input, num_neurons_hidden_1, num_output);
    //struct fann *ann = fann_create_standard(num_layers, num_input, num_neurons_hidden_1, num_neurons_hidden_2, num_output);
    fann_set_activation_function_hidden(ann, FANN_SIGMOID);
    fann_set_activation_function_output(ann, FANN_SIGMOID);

	fann_set_learning_rate(ann, 0.73);
	printf("Taxa de aprendizado: %f\n", fann_get_learning_rate(ann));
	
	fann_set_learning_momentum(ann, 0.0);
	printf("Taxa de momentum: %f\n", fann_get_learning_momentum(ann));
	
	fann_set_callback(ann, test_callback);
	
    fann_train_on_file(ann, "treinamento.data", max_epochs, epochs_between_reports, desired_error);
    
    fann_save(ann, "futebol_float.net");
    fann_destroy(ann);
    return 0;
}
