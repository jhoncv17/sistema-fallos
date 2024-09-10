import mysql.connector
from mysql.connector import Error
from telegram import Update
from telegram.ext import Application, CommandHandler, ContextTypes
import logging

# Configuración de la conexión a la base de datos
def conectar_base_de_datos():
    try:
        db_connection = mysql.connector.connect(
            host="localhost",
            user="root",
            password="",
            database="ReportesFallasDB"
        )
        print("Conexión a la base de datos establecida.")
        return db_connection
    except Error as e:
        print(f"Error al conectar a la base de datos: {e}")
        exit()

# Define tu token de acceso aquí
TOKEN = '7137268645:AAEw0Bbtrm4QlutBW6HS9buyfK8tJD_O0vg'

# Lista de IDs de chat de usuarios autorizados
USUARIOS_AUTORIZADOS = [5133986403, 7276534181]  # Agrega aquí los IDs de chat de los usuarios

# Configurar el logging
logging.basicConfig(format='%(asctime)s - %(name)s - %(levelname)s - %(message)s',
                    level=logging.INFO)
logger = logging.getLogger(__name__)

# Comando /start
async def start(update: Update, context: ContextTypes.DEFAULT_TYPE) -> None:
    chat_id = update.message.chat_id
    if chat_id in USUARIOS_AUTORIZADOS:
        await update.message.reply_text('¡Hola! Envíame el comando /reportes para obtener los reportes no enviados.')
    else:
        await update.message.reply_text('Acceso restringido, propiedad de Project-DATA.')

# Comando /reportes
async def reportes(update: Update, context: ContextTypes.DEFAULT_TYPE) -> None:
    chat_id = update.message.chat_id
    if chat_id in USUARIOS_AUTORIZADOS:
        db_connection = conectar_base_de_datos()
        cursor = db_connection.cursor()
        try:
            cursor.execute("SELECT * FROM RegistroFallas WHERE enviado = 0")
            reportes = cursor.fetchall()
            if reportes:
                mensajes = []
                for reporte in reportes:
                    resumen = f"ID: {reporte[0]}\nÁrea: {reporte[1]}\nProblema: {reporte[2]}"
                    mensajes.append(resumen)
                    # Marcar el reporte como enviado en la base de datos
                    cursor.execute("UPDATE RegistroFallas SET enviado = 1 WHERE report_id = %s", (reporte[0],))
                db_connection.commit()
                await update.message.reply_text("\n\n".join(mensajes))
                logger.info(f"Enviados {len(reportes)} reportes.")
            else:
                await update.message.reply_text("No hay reportes nuevos.")
        except Error as e:
            await update.message.reply_text(f"Error al ejecutar la consulta SQL: {e}")
        finally:
            cursor.close()
            db_connection.close()
    else:
        await update.message.reply_text('Acceso restringido, propiedad de Project-DATA.')

# Configurar el bot
def main():
    application = Application.builder().token(TOKEN).build()

    application.add_handler(CommandHandler("start", start))
    application.add_handler(CommandHandler("reportes", reportes))

    application.run_polling()

if __name__ == '__main__':
    main()
