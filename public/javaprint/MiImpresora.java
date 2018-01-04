import java.awt.print.PrinterJob;
import java.io.ByteArrayInputStream;
import java.io.InputStream;
import java.io.PrintStream;
import javax.print.Doc;
import javax.print.DocFlavor;
import javax.print.DocPrintJob;
import javax.print.PrintService;
import javax.print.PrintServiceLookup;
import javax.print.SimpleDoc;

public class MiImpresora
{
  PrintService miPrinter;
  
  public MiImpresora()
  {
    miPrinter = PrintServiceLookup.lookupDefaultPrintService();
    System.out.println("Impresora default: " + miPrinter.toString());
  }
  

  public String getCurrentPrinter()
  {
    return miPrinter.toString();
  }
  
  public String getName() {
    return miPrinter.getName();
  }
  
  public void setPrinter(String name) {
    PrintService[] printServices = PrinterJob.lookupPrintServices();
    for (PrintService printService : printServices) {
      if (name.equals(printService.getName())) {
        miPrinter = printService;
        System.out.println("Seleccionando " + miPrinter.getName());
      }
    }
  }
  
  public String[] getNames() {
    PrintService[] printServices = PrinterJob.lookupPrintServices();
    String[] ret = new String[printServices.length];
    int i = 0;
    for (PrintService printService : printServices) {
      String name = printService.getName();
      ret[(i++)] = name;
    }
    return ret;
  }
  
  public void Imprimir(String sample) {
    String data = sample;
    try
    {
      DocPrintJob job = miPrinter.createPrintJob();
      
      InputStream is = new ByteArrayInputStream(data.getBytes());
      DocFlavor flavor = javax.print.DocFlavor.INPUT_STREAM.AUTOSENSE;
      
      System.out.println("Imprimiendo data en " + miPrinter.getName() + " (" + data.length() + " caracteres)");
      Doc doc = new SimpleDoc(is, flavor, null);
      job.print(doc, null);
      is.close();
      System.out.println("Listo!!");
    }
    catch (Exception e) {
      e.printStackTrace();
    }
  }
}
