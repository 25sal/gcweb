#!/usr/bin/python3
from bokeh.plotting import figure,output_file,show,ColumnDataSource
from bokeh.models import DatetimeTickFormatter
import pandas
import datetime as dt

#Leggiamo i dati dal file .csv utilizzando pandas e sfruttando come delimitatore lo spazio
df = pandas.read_csv('0_run_4_1_ein.csv',sep = ' ')

#Converto il dizionario in lista
energy = df['energy'].tolist()

#Convertiamo epochUnix nel formato data
df['date'] = pandas.to_datetime(df['date'], origin='unix',unit = 's')

#Estraggo le ore
ore = df['date'].dt.time

#Ora Iniziale
d0 = dt.timedelta(hours=ore[0].hour, minutes=ore[0].minute, seconds=ore[0].second, microseconds=ore[0].microsecond)

#Inizializzo la lista della potenza
power = [0]

#Calcolo della potenza
for i in range(len(ore)-2):
    
    #Differenza Ora corrente-Ora Iniziale
     
     d1 = dt.timedelta(hours=ore[i+1].hour, minutes=ore[i+1].minute, seconds=ore[i+1].second, microseconds=ore[i+1].microsecond)
     dx = d1 - d0

    #Conversione secondi->ore
     sectohour = (dx.total_seconds())/3600

    # Calcolo Potenza(kW) da Energia(kWH)
     power += [(energy[i+1]-energy[i])/sectohour]
     d0 = d1

	
     



#Utilizziamo ColumnDataSorce per contenere i dati
sorgente = ColumnDataSource(df)
datax = df['date']
datax = datax[:-1]
data = {'x_values': datax,
        'y_values': power}
sorgente2 = ColumnDataSource(data=data)


output_file('index.html')

#Costruiamo il plot
p = figure(

    plot_width = 1500,
    plot_height = 600,
    title = 'Energia comulativa e Potenza nel tempo',
    x_axis_label = 'Data',
    y_axis_label = 'Energia(kW/h),Potenza(kW)',
    x_axis_type = 'datetime'
    

)

p.xaxis.formatter = DatetimeTickFormatter(
    
    years="20%y/%m/%d %H:%M",
    days="20%y/%m/%d %H:%M",
    months="20%y/%m/%d %H:%M",
    hours="20%y/%m/%d %H:%M",
    minutes="20%y/%m/%d %H:%M"
    
    ) 


#Fissiamo il gliph da utilizzare, nel nostro caso una semplice linea
p.line(

    x = 'date',
    y = 'energy',
    source = sorgente,
    legend_label = 'Energia(kW/h)',
    line_width=4,
    color = 'red',
    alpha = 0.8

)

p.line(

    x = 'x_values',
    y = 'y_values',
    source = sorgente2,
    legend_label = 'Potenza(kW)',
    line_width=4,
    color = 'blue',
    alpha = 0.8

)



#Mostro il grafico
#show(p)
